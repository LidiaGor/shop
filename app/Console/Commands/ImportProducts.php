<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\ProductsGroups;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /*
        $products_groups = ProductsGroups::query()->get()->pluck('id', 'slug');
        $products_old = DB::table('products_old')->get();

        foreach ($products_old as $po) {
            $product = new Product();

            $product->name = $po->name;
            $product->slug = Str::slug($po->name);

            $cnt = 0;
            while (Product::query()
                ->where('slug', $product->slug)
                ->first()
            ) {
                $product->slug = Str::slug($po->name) . '_' . ++$cnt;
            }

            switch ($po->unit) {
                case 'PCE':
                    $product->unit = 'шт.';
                    break;
                case 'KGM':
                    $product->unit = 'кг';
                    break;
                case 'LTR':
                    $product->unit = 'л';
                    break;
                case 'MTR':
                    $product->unit = 'м';
                    break;
                case 'ЫЫЫ':
                    $product->unit = 'уп.';
                    break;
                default:
                    $product->unit = '';
                    break;
            }

            $product->specification = $po->specification;
            $product->quantity = $po->quantity;
            $product->description = $po->description;
            $product->history = $po->history;
            $product->price = $po->price;
            $product->author_id = 0;

            //            \Storage::disk('product')->url('20230526_141110_647093ce40325.jpg');
            $product->gallery = preg_split("/\t+/", $po->images);

//            dd(\Storage::disk('product')->url($product->gallery[0]));

            $product->save();

            $product->products_groups()->sync([$products_groups[$po->category]]);
            //            dd(
            //                $products_groups[$po->category],
            //                $products_old->first()->toArray(),
            //                $product
            //            );
        }


        dd('end migration');*/
    }
}
