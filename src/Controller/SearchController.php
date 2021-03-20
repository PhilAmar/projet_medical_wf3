<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Repository\PatientRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{


    /**
     * @Route("/searchrender", name="searchrender")
     */
    public function search(PatientRepository $repository, Request $request, PaginatorInterface $paginator)
    {

       $patient = $repository->search($request->query->get('search'));

       // si la requête retourne un patient, l'utilisateur est renvoyé vers la page detail
        if (count($patient) === 1){

            return $this->render('details.html.twig',
                [
                    'patient' => $patient[0]
                ]
            );
        }
        // si la requête ne retourne pas de patient, l'utilisateur est renvoyé vers une page
        // lui indiquant que sa requête n'a pas retourné de résultats
        elseif (count($patient) === 0){
            return $this->render('message.html.twig',
                [

                    'patient' => $patient,

                ]
            );
        }
        // si plusieurs patients correspondent à la requête, l'utilisateur est renvoyé vers le tableau
        // présentant ceux-ci
        else {

            $patients = $paginator->paginate(
                $patient, // on passe les données
                $request->query->getInt('page', 1) //numero 1 page par defaut

            );

            return $this->render('find.html.twig',
                [
                    'patients' => $patients

                ]
            );

        }

    }

    /**
     * @Route("/handle_search")
     * @return JsonResponse
     */
    public function autocomplete(Request $request)
    {

        $term = $request->query->get('query');

        $array = $this->getDoctrine()
            ->getManager()
            ->getRepository(Patient::class)
            // la méthode présente dans le repository patient est utilisée ici en paramètre
            ->autocomplete($term);

        // le résultat est ensuite encodé au format json pour l'appel en ajax
        return new JsonResponse($array);
    }






}
