<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PeTrackerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
   public function rules(): array
    {
        return [
            'date' => 'required|date',
            'dpr_no' => 'nullable|string|max:255',
            'sites_names' => 'required|string',
            'activity' => 'required|in:LAYING,COMMISSIONING,EXCAVATION,FLUSHING,JOINT,SR INSTALLATION',
            'mukadam_name' => 'nullable|string|max:255',
            'supervisor' => 'nullable|string|max:255',
            'tpi_name' => 'nullable|string|max:255',
            'ra_bill_no' => 'nullable|string|max:255',
            
            // Measurement fields - all optional numeric values
            '32_mm_laying_open_cut' => 'nullable|numeric|min:0',
            '63_mm_laying_open_cut' => 'nullable|numeric|min:0',
            '90_mm_laying_open_cut' => 'nullable|numeric|min:0',
            '125_mm_laying_open_cut' => 'nullable|numeric|min:0',
            '32_mm_manual_boring' => 'nullable|numeric|min:0',
            '63_mm_manual_boring' => 'nullable|numeric|min:0',
            '90_mm_manual_boring' => 'nullable|numeric|min:0',
            '125_mm_manual_boring' => 'nullable|numeric|min:0',
            '32_mm_manual_boring_casing_50mm' => 'nullable|numeric|min:0',
            '63_mm_manual_boring_casing_90mm' => 'nullable|numeric|min:0',
            '90_mm_manual_boring_casing_125mm' => 'nullable|numeric|min:0',
            '125_mm_manual_boring_casing_160mm' => 'nullable|numeric|min:0',
            'breaking_hard_rock_completion' => 'nullable|numeric|min:0',
            'excavation_beyond_2m_depth' => 'nullable|numeric|min:0',
            'breaking_hard_surface_cutter_brea_ker' => 'nullable|numeric|min:0',
            'rcc_cutting_breaking_150' => 'nullable|numeric|min:0',
            'pcc_cutting_breaking_150' => 'nullable|numeric|min:0',
            
            // Installation fields
            'restoration_asphalted_surface' => 'nullable|numeric|min:0',
            'restoration_cement_concrete' => 'nullable|numeric|min:0',
            'restoration_tiles_pb_kerstone_brick' => 'nullable|numeric|min:0',
            'restoration_reinforced_cement_concrete' => 'nullable|numeric|min:0',
            'const_supply_installation_vc' => 'nullable|numeric|min:0',
            'installation_sr_5_regulator' => 'nullable|numeric|min:0',
            'installation_of_5_srm' => 'nullable|numeric|min:0',
            'installation_of_b_10_srm' => 'nullable|numeric|min:0',
            'installation_of_b_25_srm' => 'nullable|numeric|min:0',
            'installation_of_b_50_srm' => 'nullable|numeric|min:0',
            'installation_of_b_100_srm' => 'nullable|numeric|min:0',
            
            // Pipe fitting fields
            'supply_install_route_markers_type_b' => 'nullable|numeric|min:0',
            'supply_install_markers_type_b' => 'nullable|numeric|min:0',
            'hard_barricading_for_mp_pipeline' => 'nullable|numeric|min:0',
            'barricating_for_lp_pipeline' => 'nullable|numeric|min:0',
            'liasoning_statutory_conc_ern_authorities' => 'nullable|numeric|min:0',
            'pcc_124_by_mass' => 'nullable|numeric|min:0',
            'pcc_148_by_mass' => 'nullable|numeric|min:0',
            'rcc_of_grade_m20' => 'nullable|numeric|min:0',
            'rcc_of_grade_m25' => 'nullable|numeric|min:0',
            'brick_work_m75_cement_mortar_134' => 'nullable|numeric|min:0',
            'rcc_of_grade_m25_for_drain_cross_over' => 'nullable|numeric|min:0',
            'pe_service_lines_of_cut_20mm' => 'nullable|numeric|min:0',
            'installation_of_34_nb' => 'nullable|numeric|min:0',
            'individual_house_12_nb_gi_upto_mcv' => 'nullable|numeric|min:0',
            'individual_house_gi_cu_rom_mcv_to_av' => 'nullable|numeric|min:0',
            'individual_house_conversio_n' => 'nullable|numeric|min:0',
            'apt_high_rise_flats_con_rom_mcv_to_av' => 'nullable|numeric|min:0',
            'apt_high_rise_con_rom_mcv_to_av' => 'nullable|numeric|min:0',
            'apt_high_rise_flats_con_conversio_n' => 'nullable|numeric|min:0',
            'riser_or_header_inst_12' => 'nullable|numeric|min:0',
            'riser_or_header_inst_1' => 'nullable|numeric|min:0',
            'riser_or_header_inst_114_12' => 'nullable|numeric|min:0',
            'welded_riser_12_nb' => 'nullable|numeric|min:0',
            'welded_riser_1_nb' => 'nullable|numeric|min:0',
            'welded_riser_112_nb' => 'nullable|numeric|min:0',
            'welded_riser_2_nb' => 'nullable|numeric|min:0',
            
            // Testing fields
            'additional_point_customer_request' => 'nullable|numeric|min:0',
            'installation_test_com_mission_upto_g10' => 'nullable|numeric|min:0',
            'installation_test_com_mission_above_g10' => 'nullable|numeric|min:0',
            'industrial_hookup_upto_2_inlet' => 'nullable|numeric|min:0',
            'industrial_hookup_4_inlet' => 'nullable|numeric|min:0',
            'industrial_hookup_with_drs' => 'nullable|numeric|min:0',
            'hal_hume_un' => 'nullable|numeric|min:0',
            '20mm_ec' => 'nullable|numeric|min:0',
            '32mm_ec' => 'nullable|numeric|min:0',
            '63mm_ec' => 'nullable|numeric|min:0',
            '90mm_ec' => 'nullable|numeric|min:0',
            '125mm_ec' => 'nullable|numeric|min:0',
            '32mm_elbow' => 'nullable|numeric|min:0',
            '63mm_elbow' => 'nullable|numeric|min:0',
            'flushing_testing_done' => 'nullable|string|max:255',
            'commissioning' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'date.required' => 'The date field is required.',
            'sites_names.required' => 'The site names field is required.',
            'activity.required' => 'The activity field is required.',
            'activity.in' => 'The selected activity is invalid.',
            '*.numeric' => 'The :attribute must be a number.',
            '*.min' => 'The :attribute must be at least 0.',
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     */
    public function attributes(): array
    {
        return [
            'dpr_no' => 'DPR number',
            'sites_names' => 'site names',
            'mukadam_name' => 'mukadam name',
            'tpi_name' => 'TPI name',
            'ra_bill_no' => 'RA bill number',
            '32_mm_laying_open_cut' => '32 MM laying open cut',
            '63_mm_laying_open_cut' => '63 MM laying open cut',
            '90_mm_laying_open_cut' => '90 MM laying open cut',
            '125_mm_laying_open_cut' => '125 MM laying open cut',
        ];
    }
}
