<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Entity\Rdv;
use App\Entity\Visite;
use App\Form\PatientType;
use App\Form\RdvType;
use App\Form\VisiteType;
use App\Repository\PatientRepository;
use App\Repository\RdvRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



class IndexController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index( Request $request, EntityManagerInterface $manager, PatientRepository $patient)
    {
        $repo = $this->getDoctrine()->getRepository(Rdv::class);
        $rdvs = $repo->findBy(
            [
                'dateRdv'=> new \DateTime()
            ],
            [
                'heureRdv'=> 'ASC'
            ]



        );
        // $rdvs->getPatient($patient);


        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'rdvs'=>$rdvs,
            'patient'=>$patient,


        ]);
    }

    /**
     * @Route("/create")
     * @Route("/edit/{id}", name="patient_edit")
     */
    public function create(Patient $patient = null, Request $request, EntityManagerInterface $manager)
    {

        if (!$patient){
            $creation = true;
            $patient = new Patient();
        }

        $form = $this->createForm(PatientType::class, $patient);

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
            if (!$patient->getId()){
                $patient->setDatecrea(new \DateTime());
            }

            $manager->persist($patient);

            $manager->flush();

            if (isset($creation)) {
                $this->addFlash('success', 'Votre patient est créé avec succés');
            }else{
                $this->addFlash('update', 'Votre patient a été mis à jour avec succés');
            }

            return $this->redirectToRoute('app_index_find', [
                'id'=>$patient->getId()

            ]);

        }

        return $this->render("create.html.twig",
            [
                'FormPatient'=> $form->createView(),
                'editMode'=> $patient->getId() !== null
            ]
        );
    }



    /**
     * @Route("/find")
     */
    public function find(Request $request, PaginatorInterface $paginator)
    {


        $repo = $this->getDoctrine()->getRepository(Patient::class);

        $patients = $repo->findAll();

        $patients = $repo->findBy(array(), array('nom' => 'ASC'));

        $patients = $paginator->paginate(
            $patients, // on passe les données
            $request->query->getInt('page', 1), //numero 1 page par defaut
            10 // limite de 10 patients par page

        );

        return $this->render("find.html.twig", [
            'patients'=>$patients

        ]);

    }




    /**
     * @Route("/rv/{id}")
     */
    public function rv(Request $request, Patient $patient, PatientRepository $repository, EntityManagerInterface $manager, $id)
    {

        $rdv = new Rdv();

        $rdv->setPatient($patient);

        $form = $this->createForm(RdvType::class, $rdv );

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){



            $manager->persist($rdv);

            $manager->flush();

            return $this->redirectToRoute('index');

        }


        return $this->render("rv.html.twig", [
            'formRdv' => $form->createView(),
            'patient'=>$patient

        ]);

    }

    /**
     * @Route("details/{id}")
     */
    public function details(PatientRepository $patient, EntityManagerInterface $manager, $id)
    {
        $patient = $patient->find($id);
        return $this->render('details.html.twig',
            [
                'patient'=>$patient
            ]
        );
    }

    /**
     * @Route("/delete/{id}")
     */
    public function delete(Request $request, Patient $patient)
    {

        $delete = $this->getDoctrine()->getManager();
        $delete->remove($patient);
        $delete->flush();
        $this->addFlash('success', 'Votre patient a été supprimé avec succés');
        return $this->redirectToRoute('app_index_find');
    }



    /**
     * @Route("/visite/{id}")
     */
    public function visite(Request $request, Patient $patient, PatientRepository $patientRepository, EntityManagerInterface $manager, $id)
    {
        $visite= new Visite();

        $visite->setPatient($patient);

        $form = $this->createForm(VisiteType::class, $visite);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $visite->setDatecrea(new \DateTime());

            $manager->persist($visite);

            $manager->flush();

            $this->addFlash('update', 'votre patient a bien été mis à jour');

            return $this->redirectToRoute('app_index_details', [
                'id'=>$patient->getId()
            ]);

        }

        return $this->render("visite.html.twig",
            [
                'FormVisite'=> $form->createView(),
                'patient'=> $patient
            ]
        );
    }
    /**
     * @Route("/listerdv")
     */
    public function listerdv(Request $request, EntityManagerInterface $manager, PatientRepository $patient, RdvRepository $rdvRepository)
    {

        $repo = $this->getDoctrine()->getRepository(Rdv::class);
        $date = new \DateTime();
        $rdvs = $repo->findAll();

        $rdvs= $repo->createQueryBuilder('rdv')

            ->where('rdv.dateRdv >= :tomorrow')
            ->setParameter('tomorrow', $date )
            ->orderBy('rdv.dateRdv', 'ASC')
            ->getQuery()
            ->execute();
        //$rdvs = $rdvs->getResult();

        // $rdvs->getPatient($patient);

        return $this->render('listerdv.html.twig', [
            'rdvs'=>$rdvs,
            'patient'=>$patient

        ]);
    }
}
