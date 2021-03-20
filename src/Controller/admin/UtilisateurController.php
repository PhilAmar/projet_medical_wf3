<?php


namespace App\Controller\admin;

use App\Entity\Utilisateurs;
use App\Form\UtilisateurType;
use App\Repository\UtilisateursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin")
 */
class UtilisateurController extends AbstractController
{
    /**
     * @Route("/inscription")
     * @Route("/edit/{id}", name="utilisateur_edit")
     */
    public function inscription(Utilisateurs $utilisateur = null, Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $manager)
    {
        if (!$utilisateur){
            $creation = true;
            $utilisateur = new Utilisateurs();
        }


        $form = $this->createForm(UtilisateurType::class, $utilisateur);

        $form->handleRequest($request);

        if($form->isSubmitted()){

            if ($form->isValid()){

                $utilisateur->setPassword($encoder->encodePassword(
                    $utilisateur,
                    $utilisateur->getPlainMdp()
                ));

                $manager->persist($utilisateur);
                $manager->flush();

                if (isset($creation)){
                    $this->addFlash('success', 'L\'utilisateur a bien été ajouté');
                }else{
                    $this->addFlash('update', 'L\'utilisateur a été mis à jour');
                }

                return $this->redirectToRoute('app_admin_utilisateur_listeutilisateurs', [
                    'id' => $utilisateur->getId()
                ]);
            }
            else{
                $this->addFlash('error', 'Le formulaire contient une erreur');
            }

        }

        return $this->render('admin/utilisateur/inscription.html.twig', [
            'form' => $form->createView(),
            'editMode'=> $utilisateur->getId() !== null
        ]);

    }

    /**
     * @Route("/liste_utilisateurs")
     */
    public function listeUtilisateurs(Request $request, PaginatorInterface $paginator)
    {
        $repo = $this->getDoctrine()->getRepository(Utilisateurs::class);

        $utilisateurs = $repo->findAll();

        $utilisateurs = $repo->findBy(array(), array('nomUtilisateur' => 'ASC'));

        $utilisateurs = $paginator->paginate(
            $utilisateurs,
            $request->query->getInt('page', 1),
            10

        );

        return $this->render('admin/utilisateur/listeUtilisateurs.html.twig', [
            'utilisateurs' => $utilisateurs
        ]);
    }



    /**
     * @Route("/delete/{id}")
     */
    public function delete(Request $request, Utilisateurs $utilisateur)
    {

        $delete = $this->getDoctrine()->getManager();
        $delete->remove($utilisateur);
        $delete->flush();
        $this->addFlash('success', 'Utilisateur supprimé avec succés');
        return $this->redirectToRoute('app_admin_utilisateur_listeutilisateurs');
    }


}