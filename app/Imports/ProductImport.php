<?php

namespace App\Imports;

use App\Models\Product;
use Exception;
use Illuminate\Console\OutputStyle;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Psy\Readline\Hoa\ConsoleOutput;
use Symfony\Component\Console\Input\ArgvInput;

class ProductImport implements ToModel, WithStartRow
{
    public $category_id;
    public $count = 1;

    public function __construct(
        $category_id
    )
    {
        $this->category_id = $category_id;
    }

    /**
     * @param Collection $collection
     */
    /*public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $product_data = [
                'category_id' => $this->category_id,
                'brand_name' =>  $row[1],
                'product_name' =>  $row[2],
                'product_price' =>  $row[3],
                'product_sale_price' =>  $row[4],
                'description' =>  $row[8],
                'product_url' =>  $row[0],
                'color_name' =>  $row[5],
                'product_size' =>  $row[6],
                'product_image_urls' =>  $row[7],
            ];
            
            $product = Product::create($product_data);
        }
    }*/


    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $product_data = [
            'category_id' => $this->category_id,
            'brand_name' =>  $row[1],
            'product_name' =>  $row[2],
            'product_price' =>  $row[3],
            'product_sale_price' =>  $row[4],
            'description' =>  $row[8],
            'product_url' =>  $row[0],
            'color_name' =>  $row[5],
            'product_size' =>  $row[6],
            'product_image_urls' =>  $row[7],
        ];
        
        $product = Product::create($product_data);
        Log::info('set');
        return $product;
       
    }

    public function startRow(): int
    {
        return 2;
    }

    // public function getConsoleOutput()
    // {
    //     return new OutputStyle(new ArgvInput(), new ConsoleOutput());
    // }


}
