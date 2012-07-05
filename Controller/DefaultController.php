<?php

namespace Informatica\PrometheusBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Leg\GoogleChartsBundle\Charts\Gallery\BarChart;

class DefaultController extends Controller
{
    /**
     * @Route("/test")
     * @Template()
     */
    public function indexAction(){
        $chartsManager = $this->get('leg_google_charts');
    	
    	$chart = $chartsManager->get('InformaticaPrometheusBundle:ExampleChart.yml');
    	
    	/*
    	 * Set datas, labels, ...
    	 */
    	$chart->setDatas(array(40,50,20));
		$chart->setLabels(array('Uno','Dos','Tres'));
    	
        return $this->render('InformaticaPrometheusBundle:Default:index.html.twig', array(
        	'chart_url' => $chartsManager->build($chart)
        ));
    }
}
