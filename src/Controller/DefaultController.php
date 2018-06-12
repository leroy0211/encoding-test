<?php

namespace App\Controller;


use App\Form\AlgorithmForm;
use App\Model\AlgorithmModel;
use App\Service\AlgorithmService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    /** @var AlgorithmService */
    private $algorithmService;

    /**
     * DefaultController constructor.
     * @param AlgorithmService $algorithmService
     */
    public function __construct(AlgorithmService $algorithmService)
    {
        $this->algorithmService = $algorithmService;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        $algorithmData = new AlgorithmModel();
        $encoded = null;

        $form = $this->createForm(AlgorithmForm::class, $algorithmData)
            ->add('submit', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var AlgorithmModel $algorithmData */
            $algorithmData = $form->getData();
            $encoded = $this->algorithmService->encodeText($algorithmData->getInput());
        }

        return $this->render('algorithm.html.twig', [
            'form' => $form->createView(),
            'encoded' => $encoded
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function api(Request $request)
    {
        $text = $request->get('text');

        return $this->json([
            'input' => $text,
            'encoded' => $this->algorithmService->encodeText($text)
        ]);
    }

}
