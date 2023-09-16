<?php

namespace App\Console\Commands;

use App\Imports\ProductImport;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class MigrateProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Products';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ini_set('memory_limit', '-1');

        

        /**
         * Using Maatwebsite/excel import excel data
         */
        // 
        /*$this->output->title('Starting import');
        $category = Category::create(['category_name' => 'Women\'s Clothing']);*/

        /*// (new ProductImport($category->id))->withOutput($this->output)->import(public_path('Products_csv/macys_Women\'s Clothing_data.csv'));
        // Excel::queueImport(new ProductImport($category->id), public_path('Products_csv/macys_Women\'s Clothing_data.csv'));
        $import = new ProductImport($category->id);
        // Excel::import($import, public_path('Products_csv/macys_Women\'s Clothing_data.csv'));
        Excel::import($import, public_path('Book1.csv'));*/

        // Excel::import(new ProductImport($category->id), public_path('Products_csv/macys_Women\'s sdfsdfClothing_data.csv'));
        /*$test = new ProductImport($category->id);
        Excel::import($test, public_path('Products_csv/macys_Women\'s sdfsdfClothing_data.csv'));
        $this->output->success('Import successful');
        return 0;*/

        /**
         * Truncate Tables
         */
        // Product::truncate();
        // Category::truncate();

        // Code Using maatwebsite/excel Import


        // Code Using CSV
        /**
         * Set Category data & files
         */
        $category_data = [
            ['category' => 'Women\'s Clothing', 'file' => "macys_Women's Clothing_data.csv"],
            ['category' => 'Women\'s Brands', 'file' => "macys_Women's Brands_data.csv"],
            ['category' => 'Plus Sizes', 'file' => "macys_Plus Sizes_data.csv"],
            ['category' => 'More Sizes', 'file' => "macys_More Sizes_data.csv"],
            ['category' => 'Juniors', 'file' => "macys_Juniors_data.csv"],
            ['category' => 'Complete Your Look', 'file' => "macys_Complete Your Look_data.csv"],
        ];
        
        foreach ($category_data as $key => $value) {
            $path = public_path('Products_csv/' . $value['file']);
            $open = fopen($path, "r");
            $fp = file($path);
            $count = 0;
            $error_in_insert_count = 0;

            // Category Data Set & Insert
            $category = Category::create([
                'category_name' => $value['category']
            ]);
            
            $this->output->title('Starting import '.$value['category']);
            sleep(1);
            $this->output->progressStart(1);
            while (($data = fgetcsv($open)) !== FALSE) {
                $this->output->progressAdvance();
                $count++;
                
                try {
                    $product_image_urls = [];
                    if(isset($data[7]))
                    {
                        $str = rtrim(ltrim($data[7], '"['), ']"');
                       
                        if(!empty($str))
                        {
                            $product_image_urls = explode(', ',$str);
                        }
                    }
                    
                    // Product Data Insert
                    $product_data = [
                        'category_id' => $category->id,
                        'brand_name' => $data[1],
                        'product_name' => $data[2],
                        'product_price' => $data[3],
                        'product_sale_price' => $data[4],
                        'description' => $data[8],
                        'product_url' => $data[0],
                        'color_name' => $data[5],
                        'product_size' => $data[6],
                        'product_image_urls' => $product_image_urls,
                    ];
                    // Log::info('data => '.print_r($product_data, true));
                    DB::beginTransaction();
                    $product = Product::create($product_data);

                    foreach($product_image_urls as $key => $image_url)
                    {
                        if(!empty($image_url))
                        {
                            $image_data = [
                                'product_image' => rtrim(ltrim($image_url, "'"), "'"),
                                'product_id' => $product->id
                            ];
                            ProductImage::create($image_data);
                        }
                        
                    }
                    DB::commit();
                } catch (Exception $ex) {
                    DB::rollBack();
                    $error_in_insert_count++;
                    Log::info("Error(".$value['file'].") to Excel Line No ==> ".$count);
                    // Log::info("Error to data => ".print_r($data[7], true));
                    // Log::info($ex->getMessage());
                    // $array = explode(',', trim($data[7], '"'));
                    // $array = json_decode(json_encode(trim($data[7], '"')), true);
                    // $array = (array)$data[7];
                    // Log::info('data => '.print_r([
                    //     'is array condition' => is_array($array) ? "true" : "false",
                    //     'make_array' => $array
                    // ], true));
                    Log::info("-------------------------------------------------------");
                }
            }
            $this->output->progressFinish();
            $this->output->success('Import successful '. $value['category'] .'=>' . $count.'('.$error_in_insert_count.')');
           
        }
        fclose($open);
        return 0;
    }
}
