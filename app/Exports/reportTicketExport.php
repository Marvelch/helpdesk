<?php

namespace App\Exports;

use App\Models\requestTicket;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class reportTicketExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = Crypt::decryptString($startDate);
        $this->endDate = Crypt::decryptString($endDate);
    }

    public function view(): View
    {
        return view('pages.request_ticket.report-tamplate', [
            'requestTickets' => requestTicket::whereBetween('created_at', [$this->startDate, $this->endDate])->get()
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        // Iterate through rows and columns
        for ($row = 1; $row <= $highestRow; $row++) {
            for ($col = 'A'; $col <= $highestColumn; $col++) {
                $cellValue = $sheet->getCell($col . $row)->getValue();

                // Check if the cell is in the header row (e.g., row 1)
                if ($row === 1) {
                    // Apply bold and custom font size for header cells
                    $sheet->getStyle($col . $row)->applyFromArray([
                        'font' => [
                            'bold' => true,
                            'size' => 12, // Adjust the font size as needed
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['argb' => '000000'],
                            ],
                        ],
                    ]);
                } else {
                    // Apply borders for non-header cells
                    $sheet->getStyle($col . $row)->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['argb' => '000000'],
                            ],
                        ],
                    ]);
                }
            }
        }

        return null;
    }
}
