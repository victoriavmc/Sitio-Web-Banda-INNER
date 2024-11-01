<?php


namespace App\Exports;

use App\Models\OrdenPago;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ComprobantesExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        // Cargar las relaciones necesarias para obtener todos los datos requeridos
        if (Auth::user()->rol->idrol == 1) {
            return OrdenPago::with(['precioServicio', 'usuario'])->get();
        }

        return OrdenPago::with(['precioServicio', 'usuario'])->where('usuarios_idusuarios', Auth::user()->idusuarios)->get();
    }

    public function headings(): array
    {
        // Define los encabezados de las columnas que deseas en el Excel
        return [
            'ID Orden de Pago',
            'N° de Factura',
            'Fecha de Pago',
            'Estado de Pago',
            'Método de Pago',
            'Precio',
            'Tipo de Venta',
            'Comprador Nombre y Apellido',
            'Usuario',
            'Correo del Usuario',
        ];
    }

    public function map($orden): array
    {
        // Mapea cada registro a un array que representa las columnas
        return [
            $orden->idordenpago,
            $orden->factura,
            $orden->diaPago,
            $orden->estadoPago,
            $orden->metodoPago,
            $orden->precioServicio->precios->first()->precio,
            $orden->precioServicio->tipoServicio,
            $orden->nombreComprador . ' ' . $orden->apellidoComprador,
            $orden->usuario->usuarioUser,
            $orden->usuario->correoElectronicoUser,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Estilo para los encabezados
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['argb' => Color::COLOR_WHITE],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF4F81BD'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ];

        // Estilo para las celdas
        $cellStyle = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        // Aplicar estilos a los encabezados
        $sheet->getStyle('A1:K1')->applyFromArray($headerStyle);

        // Aplicar estilos a todas las celdas de datos
        $sheet->getStyle('A2:K' . ($sheet->getHighestRow()))->applyFromArray($cellStyle);
    }
}
