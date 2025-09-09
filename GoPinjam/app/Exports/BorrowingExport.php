<?php
namespace App\Exports;
use App\Models\Borrowing;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BorrowingExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Borrowing::with(['item', 'user'])
                        ->get()
                        ->map(function($borrowing) {
                            return [
                                'ID Peminjaman'   => $borrowing->id,
                                'Nama Debitur'    => $borrowing->item->name ?? 'N/A',
                                'Kode Akad Kredit'=> $borrowing->item->unique_code ?? 'N/A',
                                'Nama Peminjam'   => $borrowing->user->name ?? 'N/A',
                                'Tujuan'          => $borrowing->purpose,
                                'Waktu Pinjam'    => $borrowing->borrowed_at 
                                                        ? $borrowing->borrowed_at->format('d M Y H:i') 
                                                        : '-',
                                'Waktu Kembali'   => $borrowing->returned_at 
                                                        ? $borrowing->returned_at->format('d M Y H:i') 
                                                        : '-',
                                'Status'          => $borrowing->returned_at ? 'Dikembalikan' : 'Sedang Dipinjam',
                            ];
                        });
    }

    public function headings(): array
    {
        return [
            'ID Peminjaman',
            'Nama Debitur',
            'Kode Akad Kredit',
            'Nama Peminjam',
            'Tujuan',
            'Waktu Pinjam',
            'Waktu Kembali',
            'Status',
        ];
    }
}
