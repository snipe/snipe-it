<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class LabelTemplateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'page_format' => 'LETTER',
            'page_orientation' => 'P',
            'column1_x' => $this->faker->randomFloat(2, 0, 6),
            'column2_x' => $this->faker->randomFloat(2, 0, 6),
            'row1_y' => $this->faker->randomFloat(2, 0, 6),
            'row2_y' => $this->faker->randomFloat(2, 0, 6),
            'label_width' => $this->faker->randomFloat(2, 0, 6),
            'label_height' => $this->faker->randomFloat(2, 0, 6),
            'barcode_size' => $this->faker->randomFloat(2, 0, 1),
            'barcode_margin' => $this->faker->randomFloat(2, 0, 1),
            'title_size' => $this->faker->randomFloat(2, 0, 1),
            'title_margin' => $this->faker->randomFloat(2, 0, 1),
            'field_size' => $this->faker->randomFloat(2, 0, 1),
            'field_margin' => $this->faker->randomFloat(2, 0, 1),
            'label_size' => $this->faker->randomFloat(2, 0, 1),
            'label_margin' => $this->faker->randomFloat(2, 0, 1),
            'tag_size' => $this->faker->randomFloat(2, 0, 1),
            'logo_max_width' => $this->faker->randomFloat(2, 0, 6),
            'logo_margin' => $this->faker->randomFloat(2, 0, 1),
            'measurement_unit' => 'in',
            'margin_top' => $this->faker->randomFloat(2, 0, 1),
            'margin_bottom' => $this->faker->randomFloat(2, 0, 1),
            'margin_left' => $this->faker->randomFloat(2, 0, 1),
            'margin_right' => $this->faker->randomFloat(2, 0, 1),
            'fields_supported' => 1,
            'tag_option' => 0,
            'one_d_barcode_option' => 1,
            'two_d_barcode_option' => 0,
            'logo_option' => 0,
            'title_option' => 1,
            'tape_height' => $this->faker->randomFloat(2, 0, 1),
            "tape_width" => null,
            'tape_margin_sides' => $this->faker->randomFloat(2, 0, 1),
            'tape_margin_ends' => $this->faker->randomFloat(2, 0, 1),
            'tape_text_size_mod' => $this->faker->randomFloat(2, 0, 1),
            'columns' => null,
            'rows' => null,
        ];
    }

    public function avery5267Template() {
        return $this->state(function() {
            return [
                'name' => 'Avery 5267',
                'page_format' => 'LETTER',
                'page_orientation' => 'P',
                'column1_x' => 21.6,
                'column2_x' => 169.2,
                'row1_y' => 36.1,
                'row2_y' => 72.1,
                'label_width' => 126,
                'label_height' => 36,
                'barcode_size' => .175,
                'barcode_margin' => 0,
                'title_size' => .14,
                'title_margin' => null,
                'field_size' => .15,
                'field_margin' => null,
                'label_size' => null,
                'label_margin' => null,
                'tag_size' => null,
                'logo_max_width' => null,
                'logo_margin' => null,
                'measurement_unit' => 'in',
                'margin_top' => .02,
                'margin_bottom' => 0,
                'margin_left' => .04,
                'margin_right' => .04,
                'fields_supported' => 1,
                'tag_option' => 0,
                'one_d_barcode_option' => 1,
                'two_d_barcode_option' => 0,
                'logo_option' => 0,
                'title_option' => 1,
            ];
        });
    }
    public function avery5520Template(){
        return $this->state(function() {
            return [
                'name' => 'Avery 5520',
                'page_format' => 'LETTER',
                'page_orientation' => 'P',
                'column1_x' => 13.55,
                'column2_x' => 211.55,
                'row1_y' => 36.1,
                'row2_y' => 108.1,
                'label_width' => 189.35,
                'label_height' => 72,
                'barcode_size' => null,
                'barcode_margin' => .075,
                'title_size' => .14,
                'title_margin' => .04,
                'field_size' => .15,
                'field_margin' => null,
                'label_size' => .09,
                'label_margin' => -.015,
                'tag_size' => null,
                'logo_max_width' => null,
                'logo_margin' => null,
                'measurement_unit' => 'in',
                'margin_top' => .06,
                'margin_bottom' => .06,
                'margin_left' => .06,
                'margin_right' => .06,
                'fields_supported' => 3,
                'tag_option' => 0,
                'one_d_barcode_option' => 0,
                'two_d_barcode_option' => 1,
                'logo_option' => 0,
                'title_option' => 1,
            ];
        });
    }
    public function averyL7162_2DTemplate(){
        return $this->state(function() {
            return [
                'name' => 'Avery L7162 2D Barcode',
                'page_format' => 'A4',
                'page_orientation' => 'P',
                'column1_x' => 13.25,
                'column2_x' => 301.25,
                'row1_y' => 37,
                'row2_y' => 133,
                'label_width' => 280.8,
                'label_height' => 96,
                'barcode_size' => null,
                'barcode_margin' => 1.6,
                'title_size' => 4.2,
                'title_margin' => 1.4,
                'field_size' => 4.6,
                'field_margin' => .3,
                'label_size' => 2.2,
                'label_margin' => -.5,
                'tag_size' => 4.6,
                'logo_max_width' => null,
                'logo_margin' => null,
                'measurement_unit' => 'mm',
                'margin_top' => 1,
                'margin_bottom' => 1,
                'margin_left' => 1,
                'margin_right' => 1,
                'fields_supported' => 4,
                'tag_option' => 1,
                'one_d_barcode_option' => 0,
                'two_d_barcode_option' => 1,
                'logo_option' => 0,
                'title_option' => 1,
            ];
        });
    }
    public function averyL7162_1DTemplate(){
        return $this->state(function() {
            return [
                'name' => 'Avery L7162 1D Barcode',
                'page_format' => 'A4',
                'page_orientation' => 'P',
                'column1_x' => 13.25,
                'column2_x' => 301.25,
                'row1_y' => 37,
                'row2_y' => 133,
                'label_width' => 280.8,
                'label_height' => 96,
                'barcode_size' => 6,
                'barcode_margin' => 1.4,
                'title_size' => 4.2,
                'title_margin' => 1.2,
                'field_size' => 4.2,
                'field_margin' => .3,
                'label_size' => 2.2,
                'label_margin' => -.5,
                'tag_size' => 3.2,
                'logo_max_width' => 25,
                'logo_margin' => 2.2,
                'measurement_unit' => 'mm',
                'margin_top' => 1,
                'margin_bottom' => 0,
                'margin_left' => 1,
                'margin_right' => 1,
                'fields_supported' => 3,
                'tag_option' => 1,
                'one_d_barcode_option' => 1,
                'two_d_barcode_option' => 0,
                'logo_option' => 1,
                'title_option' => 1,
            ];
        });
    }
    public function averyL163Template(){
        return $this->state(function() {
            return [
                'name' => 'Avery L163 1D Barcode',
                'page_format' => 'A4',
                'page_orientation' => 'P',
                'column1_x' => 13.25,
                'column2_x' => 301.25,
                'row1_y' => 43.05,
                'row2_y' => 151.05,
                'label_width' => 280.8,
                'label_height' => 108,
                'barcode_size' => null,
                'barcode_margin' => 1.8,
                'title_size' => 5,
                'title_margin' => 1.8,
                'field_size' => 4.8,
                'field_margin' => .3,
                'label_size' => 2.35,
                'label_margin' => -.3,
                'tag_size' => 4.8,
                'logo_max_width' => null,
                'logo_margin' => null,
                'measurement_unit' => 'mm',
                'margin_top' => 1,
                'margin_bottom' => 1,
                'margin_left' => 1,
                'margin_right' => 1,
                'fields_supported' => 4,
                'tag_option' => 1,
                'one_d_barcode_option' => 0,
                'two_d_barcode_option' => 1,
                'logo_option' => 0,
                'title_option' => 1,
            ];
        });
    }
    public function brotherTze_12mmTemplate(){
        return $this->state(function() {
            return [
                'name' => 'Brother TZE 12mm ',
                'tape_height' => 12,
                'tape_margin_sides' => 3.2,
                'tape_margin_ends' => 3.2,
                'tape_text_size_mod' => 1,
                'barcode_size' => 1,
                'barcode_margin' => .3,
                'title_size' => null,
                'title_margin' => null,
                'field_size' => null,
                'field_margin' => null,
                'label_size' => null,
                'label_margin' => null,
                'tag_size' => null,
                'measurement_unit' => 'mm',
                'fields_supported' => 1,
                'tag_option' => 1,
                'one_d_barcode_option' => 1,
                'two_d_barcode_option' => 0,
                'logo_option' => 0,
                'title_option' => 0,
            ];
        });
    }
    public function brotherTze_18mmTemplate(){
        return $this->state(function() {
            return [
                'name' => 'Brother TZE 18mm ',
                'tape_height' => 18,
                'tape_width' => 50,
                'tape_margin_sides' => 3.2,
                'tape_margin_ends' => 3.2,
                'tape_text_size_mod' => 1,
                'barcode_size' => 3.2,
                'barcode_margin' => .3,
                'title_size' => null,
                'title_margin' => null,
                'field_size' => null,
                'field_margin' => null,
                'label_size' => null,
                'label_margin' => null,
                'tag_size' => null,
                'measurement_unit' => 'mm',
                'fields_supported' => 1,
                'tag_option' => 1,
                'one_d_barcode_option' => 1,
                'two_d_barcode_option' => 0,
                'logo_option' => 0,
                'title_option' => 0,
            ];
        });
    }
    public function brotherTze_24mmTemplate(){
        return $this->state(function() {
            return [
                'name' => 'Brother TZE 24mm ',
                'tape_height' => 24,
                'tape_width' => 65,
                'tape_margin_sides' => 3.2,
                'tape_margin_ends' => 3.2,
                'tape_text_size_mod' => null,
                'barcode_size' => null,
                'barcode_margin' => 1.4,
                'title_size' => .5,
                'title_margin' => null,
                'field_size' => 3.2,
                'field_margin' => .15,
                'label_size' => 2,
                'label_margin' => -.35,
                'tag_size' => 2.8,
                'measurement_unit' => 'mm',
                'fields_supported' => 3,
                'tag_option' => 1,
                'one_d_barcode_option' => 0,
                'two_d_barcode_option' => 1,
                'logo_option' => 0,
                'title_option' => 1,
            ];
        });
    }
    public function dymolabelWriter30252Template(){
        return $this->state(function() {
            return [
                'name' => 'Label Writer 30252 ',
                'tape_height' => 1.15,
                'tape_width' => 96.52,
                'tape_margin_sides' => .1,
                'tape_margin_ends' => .1,
                'tape_text_size_mod' => null,
                'barcode_size' => null,
                'barcode_margin' => 1.8,
                'title_size' => 2,
                'title_margin' => null,
                'field_size' => 3.2,
                'field_margin' => .15,
                'label_size' => 2,
                'label_margin' => -.35,
                'tag_size' => 2.8,
                'measurement_unit' => 'mm',
                'fields_supported' => 3,
                'tag_option' => 1,
                'one_d_barcode_option' => 1,
                'two_d_barcode_option' => 1,
                'logo_option' => 0,
                'title_option' => 1,
            ];
        });
    }
    public function dymolabelWriter1933081Template(){
        return $this->state(function() {
            return [
                'name' => 'Dymo Label Writer 1933081 ',
                'tape_height' => 25,
                'tape_width' => 89,
                'tape_margin_sides' => .1,
                'tape_margin_ends' => .1,
                'tape_text_size_mod' => null,
                'barcode_size' => null,
                'barcode_margin' => 1.8,
                'title_size' => 2.8,
                'title_margin' => .5,
                'field_size' => 2.8,
                'field_margin' => .15,
                'label_size' => 2.8,
                'label_margin' => -.35,
                'tag_size' => 2.8,
                'measurement_unit' => 'mm',
                'fields_supported' => 5,
                'tag_option' => 1,
                'one_d_barcode_option' => 1,
                'two_d_barcode_option' => 1,
                'logo_option' => 0,
                'title_option' => 1,
            ];
        });
    }
    public function dymolabelWriter2112283Template(){
        return $this->state(function() {
            return [
                'name' => 'Dymo Label Writer 2112283 ',
                'tape_height' => 54,
                'tape_width' => 25,
                'tape_margin_sides' => .1,
                'tape_margin_ends' => .1,
                'tape_text_size_mod' => null,
                'barcode_size' => null,
                'barcode_margin' => 1.8,
                'title_size' => 2.8,
                'title_margin' => .5,
                'field_size' => 2.8,
                'field_margin' => .15,
                'label_size' => 2.8,
                'label_margin' => -.35,
                'tag_size' => 2.8,
                'measurement_unit' => 'mm',
                'fields_supported' => 5,
                'tag_option' => 1,
                'one_d_barcode_option' => 1,
                'two_d_barcode_option' => 1,
                'logo_option' => 0,
                'title_option' => 1,
            ];
        });
    }
}
