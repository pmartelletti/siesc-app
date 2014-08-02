<?php

namespace Siesc\GeneratorBundle\Controller;


use Siesc\PartesBundle\Security\ActionNotAllowedException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class AdminResourceController extends Controller
{
    protected $templatesRoot;
    protected $resourceName;
    protected $formType;
    protected $factory;
    protected $repository;
    protected $routingPrefix;

    /**
     * @param mixed $routingPrefix
     *
     * @return $this
     */
    public function setRoutingPrefix($routingPrefix)
    {
        $this->routingPrefix = $routingPrefix;
        return $this;
    }

    /**
     * @param mixed $factory
     *
     * @return $this
     */
    public function setFactory($factory)
    {
        $this->factory = $factory;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * @param mixed $formType
     *
     * @return $this
     */
    public function setFormType($formType)
    {
        $this->formType = $formType;

        return $this;
    }

    /**
     * @param mixed $repository
     *
     * @return $this
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFormType()
    {
        return $this->formType;
    }

    /**
     * @param mixed $resourceName
     *
     * @return $this
     */
    public function setResourceName($resourceName)
    {
        $this->resourceName = $resourceName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResourceName()
    {
        return $this->resourceName;
    }

    /**
     * @return mixed
     */
    public function getTemplatesRoot()
    {
        return $this->templatesRoot;
    }

    /**
     * @param mixed $templatesRoot
     *
     * @return $this
     */
    public function setTemplatesRoot($templatesRoot)
    {
        $this->templatesRoot = $templatesRoot;
        return $this;
    }

    public function showAction(Request $request)
    {
        $entity = $this->findOr404($request);

        return $this->render(sprintf('%s:show.html.twig', $this->templatesRoot), array(
            'entity' => $entity
        ));
    }

    /**
     * @return Response
     */
    public function indexAction()
    {
        $entities = $this->getRepository()->findAll();

        return $this->render(sprintf('%s:index.html.twig', $this->templatesRoot), array(
            'entities' => $entities
        ));
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $resource = $this->getFactory()->createNew();

        $form = $this->createForm($this->getFormType(), $resource);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->dispatchEvent('pre_create', $resource);
            $em = $this->get('doctrine.orm.entity_manager');

            $em->persist($resource);
            $em->flush();
            $this->setFlash('success', 'create');

            $this->dispatchEvent('post_create', $resource);

            return $this->redirectToResource($resource);
        }

        return $this->render(sprintf('%s:new.html.twig', $this->templatesRoot), array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request)
    {
        $resource = $this->findOr404($request);

        $form = $this->createForm($this->getFormType(), $resource);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $this->dispatchEvent('pre_edit', $resource);

            $em = $this->get('doctrine.orm.entity_manager');
            $em->flush();
            $this->setFlash('success', 'update');

            $this->dispatchEvent('post_edit', $resource);

            return $this->redirectToResource($resource);
        }

        return $this->render(sprintf('%s:edit.html.twig', $this->templatesRoot), array(
            'form' => $form->createView(),
            'entity' => $resource
        ));
    }

    public function closeAction(Request $request)
    {
        $resource = $this->findOr404($request);

        $this->dispatchEvent('pre_close', $resource);

        $resource->setClosedAt(new \DateTime());
        $this->get('doctrine.orm.entity_manager')->flush();
        $this->setFlash('success', 'close');

        $this->dispatchEvent('post_close', $resource);

        return $this->redirectToIndex();
    }

    public function openAction(Request $request)
    {
        $resource = $this->findOr404($request);

        $this->dispatchEvent('pre_open', $resource);

        $resource->setClosedAt(null);
        $this->get('doctrine.orm.entity_manager')->flush();
        $this->setFlash('success', 'open');

        $this->dispatchEvent('post_open', $resource);

        return $this->redirectToIndex();
    }

    /**
     * @param Request $request
     * @param string $identifier
     *
     * @return object
     *
     * @throws NotFoundHttpException
     */
    public function findOr404(Request $request, $identifier = 'id')
    {

        $entity = $this->getRepository()->find($request->get($identifier));

        if (!$entity) {
            throw $this->createNotFoundException(sprintf('Unable to find %s entity.', $this->resourceName));
        }

        if (!$entity) {
            throw new NotFoundHttpException(
                sprintf(
                    'Requested %s does not exist with criteria specified',
                    $this->resourceName
                )
            );
        }

        return $entity;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->getDoctrine()->getRepository($this->repository);
    }

    private function getResourcePrefix()
    {
        return str_replace(' ', '_', strtolower($this->resourceName));
    }

    private function getResourcePathPrefix()
    {
        return sprintf('data_%s', $this->getResourcePrefix());
    }

    public function redirectToResource($resource)
    {
        return $this->redirect(
            $this->generateUrl($this->routingPrefix . "_show", array('id' => $resource->getId())
        ));
    }

    public function redirectToIndex()
    {
        return $this->redirect(
            $this->generateUrl($this->routingPrefix . "_index")
        );
    }

    public function dispatchEvent($name, $resource)
    {
        $event_name = sprintf('siesc.%s.%s', $this->getResourcePrefix(), $name);
        $this->get('event_dispatcher')->dispatch($event_name, new GenericEvent($resource));
    }

    public function checkAcces($novedad, $action)
    {
        if(!$this->isGranted($action, $novedad)) {
            $redirectUrl = $this->routingPrefix . "_index";
            throw new ActionNotAllowedException($redirectUrl);
        }
    }

    public function setFlash($type, $eventName, $params = array())
    {
        /** @var FlashBag $flashBag */
        $flashBag = $this->get('session')->getBag('flashes');
        $flashBag->add($type, $this->translateFlashMessage($eventName, $params));
    }

    /**
     * @param string $event
     * @param array  $params
     *
     * @return string
     */
    private function translateFlashMessage($event, $params = array())
    {
        $resource = ucfirst(str_replace('_', ' ', $this->getResourceName()));
        $message = sprintf('admin_crud.resource.%s', $event);

        return $this->get('translator')->trans($message, array_merge(array('%resource%' => $resource), $params), 'flashes');
    }

    /**
     * @param $attributes
     * @param null $object
     *
     * @return bool
     */
    public function isGranted($attributes, $object = null)
    {
        return $this->container->get('security.context')->isGranted($attributes, $object);
    }
} 