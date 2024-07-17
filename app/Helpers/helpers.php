<?php

if (!function_exists('asset_image_path')) {
    function asset_image_path($path) {
        return asset('project/public/' . $path);
    }
}

?>
