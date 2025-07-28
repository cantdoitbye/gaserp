<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use Carbon\Carbon;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projects = [
            [
                'name' => 'Lucknow City Gas Distribution Network',
                'contract_number' => 'NEPL-2023-001',
                'location' => 'Lucknow, Uttar Pradesh',
                'description' => 'Installation of gas distribution pipeline network for residential and commercial use in Gomti Nagar area of Lucknow',
                'start_date' => Carbon::parse('2023-05-15'),
                'end_date' => Carbon::parse('2025-06-30'),
                'client_name' => 'Indraprastha Gas Limited',
                'client_contact' => 'projects@igl.co.in',
                'project_manager' => 'Rajesh Kumar',
                'pipeline_length' => 42.5,
                'pipeline_type' => 'Medium-pressure',
                'pipeline_material' => 'HDPE',
                'service_type' => 'installation',
                'status' => 'active',
            ],
            [
                'name' => 'GAIL Pipeline Repair Project - Kanpur Sector',
                'contract_number' => 'NEPL-2023-002',
                'location' => 'Kanpur, Uttar Pradesh',
                'description' => 'Emergency repair and maintenance of high-pressure natural gas transmission pipeline in Kanpur industrial sector',
                'start_date' => Carbon::parse('2023-08-10'),
                'end_date' => Carbon::parse('2024-12-31'),
                'client_name' => 'GAIL (India) Limited',
                'client_contact' => 'maintenance@gail.co.in',
                'project_manager' => 'Sunil Sharma',
                'pipeline_length' => 18.75,
                'pipeline_type' => 'High-pressure',
                'pipeline_material' => 'Steel',
                'service_type' => 'repair',
                'status' => 'active',
            ],
            [
                'name' => 'Agra-Mathura CNG Pipeline Installation',
                'contract_number' => 'NEPL-2023-003',
                'location' => 'Agra-Mathura Highway, Uttar Pradesh',
                'description' => 'Installation of CNG pipeline connecting Agra and Mathura for vehicular and industrial use',
                'start_date' => Carbon::parse('2023-03-20'),
                'end_date' => Carbon::parse('2024-09-15'),
                'client_name' => 'Central UP Gas Limited',
                'client_contact' => 'projects@cupgl.co.in',
                'project_manager' => 'Amit Patel',
                'pipeline_length' => 78.2,
                'pipeline_type' => 'High-pressure',
                'pipeline_material' => 'Steel',
                'service_type' => 'installation',
                'status' => 'active',
            ],
            [
                'name' => 'Varanasi Industrial Area Gas Infrastructure',
                'contract_number' => 'NEPL-2022-005',
                'location' => 'Varanasi, Uttar Pradesh',
                'description' => 'Installation and maintenance of gas supply infrastructure for new industrial area in Varanasi',
                'start_date' => Carbon::parse('2022-11-05'),
                'end_date' => Carbon::parse('2024-04-30'),
                'client_name' => 'Bharat Petroleum Corporation Limited',
                'client_contact' => 'industrial@bpcl.in',
                'project_manager' => 'Vikram Singh',
                'pipeline_length' => 24.5,
                'pipeline_type' => 'Medium-pressure',
                'pipeline_material' => 'Steel',
                'service_type' => 'mixed',
                'status' => 'active',
            ],
            [
                'name' => 'Gorakhpur Gas Pipeline Inspection',
                'contract_number' => 'NEPL-2022-007',
                'location' => 'Gorakhpur, Uttar Pradesh',
                'description' => 'Comprehensive inspection and integrity assessment of existing gas distribution network in Gorakhpur',
                'start_date' => Carbon::parse('2022-07-15'),
                'end_date' => Carbon::parse('2023-01-31'),
                'client_name' => 'Green Gas Limited',
                'client_contact' => 'inspection@greengas.co.in',
                'project_manager' => 'Priyanka Gupta',
                'pipeline_length' => 32.8,
                'pipeline_type' => 'Low-pressure',
                'pipeline_material' => 'HDPE/Steel',
                'service_type' => 'inspection',
                'status' => 'completed',
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
