<?php

namespace AppBundle\Admin\Controller;

use AppBundle\Admin\Form\TeamMapType;
use AppBundle\Entity\TeamMap;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Teammap controller.
 *
 * @Route("teammap")
 */
class TeamMapController extends Controller
{

    use TeamMapTrait;

    /**
     * Lists all teamMap entities.
     *
     * @Route("/", name="teammap_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $teamMaps = $em->getRepository(TeamMap::class)->findAll();

        return $this->render('admin/teammap/index.html.twig', array(
            'teamMaps'   => $teamMaps,
            'showCreate' => !(bool) $this->fetchMap()
        ));
    }

    /**
     * Creates a new teamMap entity.
     *
     * @Route("/new", name="teammap_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $map = $this->fetchMap();
        if ($map) {
            return $this->redirectToRoute('teammap_edit', ['id' => $map->getId()]);
        }

        $teamMap = new Teammap();
        $form    = $this->createForm(TeamMapType::class, $teamMap);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($teamMap);
            $em->flush();

            return $this->redirectToRoute('team_index');
        }

        return $this->render('admin/teammap/new.html.twig', array(
            'teamMap' => $teamMap,
            'form'    => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing teamMap entity.
     *
     * @Route("/{id}/edit", name="teammap_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param TeamMap $teamMap
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, TeamMap $teamMap)
    {
        $editForm = $this->createForm(TeamMapType::class, $teamMap);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('teammap_edit', array('id' => $teamMap->getId()));
        }

        return $this->render('admin/teammap/edit.html.twig', array(
            'teamMap'   => $teamMap,
            'edit_form' => $editForm->createView()
        ));
    }
}
