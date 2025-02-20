<?php

namespace App\Exports;

use App\Models\User;
// use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithHeadings;

// class ExportStudent implements FromCollection, WithHeadings
// {
//     /**
//     * @return \Illuminate\Support\Collection
//     */
//     public function collection()
//     {
//         return User::select('name','email')->get();
//     }

//     public function headings(): array{
//         return [
//             'Name',
//             'Email'
//         ];
//     }
// }

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportStudent implements FromView
{
    public function view(): View
    {
        return view('admin.exports.allStudents', [
            'students' => User::select('name','email')->get()
        ]);
    }
}
