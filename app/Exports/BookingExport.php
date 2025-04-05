<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class BookingExport implements FromView, WithHeadings,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $bookings;
    public function __construct($bookings)
    {
        $this->bookings = $bookings;
    }
    public function view(): View
    {
        return view('admin.report.booking_export', [
            'bookings' => $this->bookings,
        ]);
    }
    public function headings(): array
    {
            return [
                'Train Name',
                'Seat No',
                'Phone',
                'From',
                'To',
                'Date',
            ];
    }
    public function registerEvents(): array
{
    return [
        AfterSheet::class => function(AfterSheet $event) {

            $event->sheet->getDelegate()->getStyle('1')->getFont()->setSize(12);
            $event->sheet->getDelegate()->freezePane('A2');

                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(5);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(30);
          
                $event->sheet->getStyle('A1:G1')->getFill()->applyFromArray([
                    'fillType' => 'solid',
                    'color' => ['rgb' => 'D9D9D9'],
                ]);
          

            $event->sheet->getStyle('A1:G1')->applyFromArray([
                'font' => ['bold' => true],
            ]);

        },
    ];
}
}
