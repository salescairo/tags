<?php

namespace App\Charts;

use App\Repository\Contract\KidClassInterface;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class KidsPieChart
{
    protected $chart;
    protected $interface;

    public function __construct(LarapexChart $chart,KidClassInterface $interface)
    {
        $this->chart = $chart;
        $this->interface = $interface;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $kids =  collect();
        $labelKids = collect();
        foreach($this->interface->kidsPerClass() as $item){
            $kids->push($item['kids']);
            $labelKids->push($item['name']);
        }

        return $this->chart->pieChart()
            ->setTitle('Distribuição de Alunos por Turmas')
            ->setSubtitle('Turmas/Alunos.')
            ->addData($kids->values()->all())
            ->setLabels($labelKids->values()->all());
    }
}
