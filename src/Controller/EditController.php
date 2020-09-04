<?php

namespace App\Controller;
use App\Entity\Status;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_EDITOR")
 */
class EditController extends AbstractController
{
    /**
     * @Route("/edit/new-contrib", name="edit_new_contrib")
     */
    public function newContrib()
    {
        $listRepo = $this->getDoctrine()->getRepository(Contribution::class);

        return $this->render('edit/index.html.twig', [
            'list' => $list,
        ]);
    }
}
