<?php

/**
 * Blade File Generator for Commercial, Riser, and Ladder Modules
 * 
 * This script automatically creates blade files based on PNG templates
 * Run this script to generate all required blade files
 */

class BladeFileGenerator
{
    private $modules = [
        'commercial' => [
            'name' => 'Commercial',
            'types' => ['commercial', 'industrial', 'office', 'retail', 'restaurant', 'hotel'],
            'variable' => 'commercial',
            'plural' => 'commercials'
        ],
        'riser' => [
            'name' => 'Riser',
            'types' => ['riser', 'approach', 'main_riser', 'sub_riser', 'building_riser'],
            'variable' => 'riser',
            'plural' => 'risers'
        ],
        'ladder' => [
            'name' => 'Ladder',
            'types' => ['ladder', 'main_ladder', 'sub_ladder', 'cross_ladder', 'distribution_ladder'],
            'variable' => 'ladder',
            'plural' => 'ladders'
        ]
    ];

    private $files = ['index', 'create', 'edit', 'show', 'import'];
    private $basePath = 'resources/views/panel/';

    public function generateAllFiles()
    {
        foreach ($this->modules as $moduleKey => $moduleConfig) {
            $this->generateModuleFiles($moduleKey, $moduleConfig);
        }
    }

    private function generateModuleFiles($moduleKey, $config)
    {
        echo "Generating files for {$config['name']} module...\n";
        
        // Create directory if it doesn't exist
        $moduleDir = $this->basePath . $moduleKey;
        if (!is_dir($moduleDir)) {
            mkdir($moduleDir, 0755, true);
        }

        foreach ($this->files as $file) {
            $this->generateFile($moduleKey, $config, $file);
        }
    }

    private function generateFile($moduleKey, $config, $fileName)
    {
        $sourcePath = $this->basePath . "png/{$fileName}.blade.php";
        $targetPath = $this->basePath . "{$moduleKey}/{$fileName}.blade.php";

        if (!file_exists($sourcePath)) {
            echo "Warning: Source file {$sourcePath} not found!\n";
            return;
        }

        $content = file_get_contents($sourcePath);
        $content = $this->replaceContent($content, $moduleKey, $config);

        file_put_contents($targetPath, $content);
        echo "Created: {$targetPath}\n";
    }

    private function replaceContent($content, $moduleKey, $config)
    {
        $replacements = [
            // Route replacements
            "route('png." => "route('{$moduleKey}.",
            
            // Variable replacements
            '$pngs' => '$' . $config['plural'],
            '$png' => '$' . $config['variable'],
            
            // Class and model replacements
            'PNG' => $config['name'],
            'png' => $moduleKey,
            
            // Page titles and headers
            'PNG Data Tracker' => $config['name'] . ' Data Tracker',
            'PNG Jobs Report' => $config['name'] . ' Jobs Report',
            'Add New PNG Job' => 'Add New ' . $config['name'] . ' Job',
            'Edit PNG Job' => 'Edit ' . $config['name'] . ' Job',
            'PNG Job Details' => $config['name'] . ' Job Details',
            'Import PNG Data' => 'Import ' . $config['name'] . ' Data',
            
            // Model references
            '\\App\\Models\\Png::' => '\\App\\Models\\' . $config['name'] . '::',
            
            // Form and field references
            'PNG Type' => $config['name'] . ' Type',
            'png_type' => $moduleKey . '_type',
            'pngType' => $moduleKey . 'Type',
            
            // Measurement type loading
            'png-measurement-types.get-by-png-type' => 'png-measurement-types.get-by-png-type',
            
            // File storage paths
            'png_scan_copies' => $moduleKey . '_scan_copies',
            'png_job_cards' => $moduleKey . '_job_cards',
            'png_autocad_dwg' => $moduleKey . '_autocad_dwg',
            'png_site_visit_reports' => $moduleKey . '_site_visit_reports',
            'png_other_documents' => $moduleKey . '_other_documents',
            'png_additional_docs' => $moduleKey . '_additional_docs',
            'png_autocad_drawings' => $moduleKey . '_autocad_drawings',
            'png_certificates' => $moduleKey . '_certificates',
        ];

        // Apply replacements
        foreach ($replacements as $search => $replace) {
            $content = str_replace($search, $replace, $content);
        }

        // Special handling for measurement type options
        $content = $this->updateMeasurementTypeOptions($content, $moduleKey, $config);

        return $content;
    }

    private function updateMeasurementTypeOptions($content, $moduleKey, $config)
    {
        // Update the select options for module types
        $optionsHtml = '';
        foreach ($config['types'] as $type) {
            $label = ucfirst(str_replace('_', ' ', $type));
            $selected = "{{ old('{$moduleKey}_type') == '{$type}' ? 'selected' : '' }}";
            $optionsHtml .= "<option value=\"{$type}\" {$selected}>{$label}</option>\n                                ";
        }

        // Replace the PNG type options section
        $pattern = '/<select name="png_type".*?<\/select>/s';
        $replacement = "<select name=\"{$moduleKey}_type\" id=\"{$moduleKey}_type\" class=\"form-control @error('{$moduleKey}_type') is-invalid @enderror\" onchange=\"loadMeasurementTypes()\" required>\n";
        $replacement .= "                                <option value=\"\">Select " . $config['name'] . " Type</option>\n";
        $replacement .= "                                " . $optionsHtml;
        $replacement .= "</select>";

        $content = preg_replace($pattern, $replacement, $content);

        return $content;
    }

    public function createDirectories()
    {
        foreach (array_keys($this->modules) as $moduleKey) {
            $dir = $this->basePath . $moduleKey;
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
                echo "Created directory: {$dir}\n";
            }
        }
    }

    public function generateSampleRoutes()
    {
        echo "\n=== Sample Routes (add to web.php) ===\n";
        
        foreach ($this->modules as $moduleKey => $config) {
            echo "\n// {$config['name']} Routes\n";
            echo "Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {\n";
            echo "    Route::prefix('{$moduleKey}')->name('{$moduleKey}.')->group(function () {\n";
            echo "        Route::get('/', [" . $config['name'] . "Controller::class, 'index'])->name('index');\n";
            echo "        Route::get('create', [" . $config['name'] . "Controller::class, 'create'])->name('create');\n";
            echo "        Route::post('/', [" . $config['name'] . "Controller::class, 'store'])->name('store');\n";
            echo "        Route::get('{" . $moduleKey . "}', [" . $config['name'] . "Controller::class, 'show'])->name('show');\n";
            echo "        Route::get('{" . $moduleKey . "}/edit', [" . $config['name'] . "Controller::class, 'edit'])->name('edit');\n";
            echo "        Route::put('{" . $moduleKey . "}', [" . $config['name'] . "Controller::class, 'update'])->name('update');\n";
            echo "        Route::delete('{" . $moduleKey . "}', [" . $config['name'] . "Controller::class, 'destroy'])->name('destroy');\n";
            echo "        Route::get('import/form', [" . $config['name'] . "Controller::class, 'showImportForm'])->name('import.form');\n";
            echo "        Route::post('import', [" . $config['name'] . "Controller::class, 'import'])->name('import');\n";
            echo "        Route::get('export', [" . $config['name'] . "Controller::class, 'export'])->name('export');\n";
            echo "    });\n";
            echo "});\n";
        }
    }

    public function generateNavigationMenu()
    {
        echo "\n=== Sample Navigation Menu Items ===\n";
        
        foreach ($this->modules as $moduleKey => $config) {
            $icon = $this->getModuleIcon($moduleKey);
            echo "<li class=\"nav-item\">\n";
            echo "    <a class=\"nav-link\" href=\"{{ route('{$moduleKey}.index') }}\">\n";
            echo "        <i class=\"{$icon}\"></i> {$config['name']} Jobs\n";
            echo "    </a>\n";
            echo "</li>\n\n";
        }
    }

    private function getModuleIcon($moduleKey)
    {
        $icons = [
            'commercial' => 'fas fa-building',
            'riser' => 'fas fa-arrows-alt-v',
            'ladder' => 'fas fa-project-diagram'
        ];
        
        return $icons[$moduleKey] ?? 'fas fa-cogs';
    }
}

// Usage
echo "=== Blade File Generator for PNG Modules ===\n\n";

$generator = new BladeFileGenerator();

echo "Step 1: Creating directories...\n";
$generator->createDirectories();

echo "\nStep 2: Generating blade files...\n";
$generator->generateAllFiles();

echo "\nStep 3: Sample routes and navigation...\n";
$generator->generateSampleRoutes();
$generator->generateNavigationMenu();

echo "\n=== Generation Complete! ===\n";
echo "✅ All blade files have been created\n";
echo "✅ Remember to update your routes\n";
echo "✅ Remember to update your navigation menu\n";
echo "✅ Test each module after creation\n\n";

echo "Next steps:\n";
echo "1. Run migrations: php artisan migrate\n";
echo "2. Run seeders: php artisan db:seed --class=PngMeasurementTypesSeeder\n";
echo "3. Update your routes/web.php file\n";
echo "4. Update your navigation menu\n";
echo "5. Test each module functionality\n";

?>