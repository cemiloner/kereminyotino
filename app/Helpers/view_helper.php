<?php

/**
 * View helper function - renders a view file with provided data
 * 
 * @param string $path Path to the view file (without .php extension)
 * @param array $data Data to be extracted as variables in the view
 * @return string Rendered view content
 * @throws Exception If view file doesn't exist
 */
function view($path, array $data = []) 
{
    // Define the full path to the view file
    $viewPath = __DIR__ . '/../../app/Views/' . $path . '.php';
    
    // Check if the view file exists
    if (!file_exists($viewPath)) {
        throw new Exception("View file not found: {$path}.php");
    }
    
    // Start output buffering to capture view output
    ob_start();
    
    // Extract variables from the data array
    extract($data, EXTR_SKIP);
    
    // Include the view file
    require $viewPath;
    
    // Return the captured output and end buffering
    return ob_get_clean();
}

/**
 * View with layout helper function - renders a view within a layout
 * 
 * @param string $view Path to the view file (without .php extension)
 * @param array $data Data to be extracted as variables in the view
 * @param string $layout Layout file to be used (without .php extension)
 * @return string Rendered view content within layout
 */
function view_with_layout($view, array $data = [], $layout = 'default') 
{
    // Capture the view content
    $content = view($view, $data);
    
    // Render the layout with the content
    return view("layouts/{$layout}", ['content' => $content] + $data);
}