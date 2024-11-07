<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

if (! function_exists('buildTree')) {
    function buildTree(array &$elements, $idParent = 0)
    {
        $branch = [];
        foreach ($elements as $element) {
            $element = (array) $element;
            if ($element['parent'] == $idParent) {
                $children = buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                unset($element['parent']);
                $branch[] = $element;
            }
        }

        return $branch;
    }
}
function getSql($model)
{
    $replace = function ($sql, $bindings) {
        $needle = '?';
        foreach ($bindings as $replace) {
            $pos = strpos($sql, $needle);
            if ($pos !== false) {
                if (gettype($replace) === 'string') {
                    $replace = ' "' . addslashes($replace) . '" ';
                }
                $sql = substr_replace($sql, $replace, $pos, strlen($needle));
            }
        }

        return $sql;
    };
    $sql = $replace($model->toSql(), $model->getBindings());

    return $sql;
}


function unFormattedPhoneNumber($formattedNumber)
{
    // Remove any characters that are not digits
    $unformattedNumber = preg_replace('/\D/', '', $formattedNumber);

    // Ensure the number starts with '62' after removing non-digit characters
    if (substr($unformattedNumber, 0, 2) !== '62') {
        return 'Invalid Indonesian phone number.';
    }
    str_replace('62', '', $unformattedNumber);

    return $unformattedNumber;
}
if (! function_exists('buildTreeMenu')) {

    function buildTreeMenu(array &$elements, $idParent = '0')
    {
        $branch = [];
        foreach ($elements as $element) {
            $element = (array) $element;
            if ($element['parent'] === $idParent) {
                $children = buildTreeMenu($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                unset($element['parent']);
                $branch[] = $element;
            }
        }

        return $branch;
    }
}

if (! function_exists('checkPermissionMenu')) {
    function checkPermissionMenu($id, $role)
    {
        return DB::table('role_menus')->where(['menu_id' => $id, 'role_id' => $role])->count() > 0 ? true : false;
    }
}

if (! function_exists('buildMenu')) {

    function buildMenu(array &$elements, $place = 0)
    {
        $html = '';
        foreach ($elements as $element) {
            if (getRole() == 'Developer' || checkPermissionMenu($element['id'], auth()->user()->role->id)) {
                if ($place == 0) {
                    if (isset($element['children'])) {
                        $children = buildMenu($element['children']);
                        $html .= '<li class="menu-item">
                        <a class="nav-link menu-link" href="#sideBar' . $element['id'] . '" data-bs-toggle="collapse" role="button" aria-expanded="false"
                        aria-controls="sideBar' . $element['id'] . '">
                        <i class="ri-apps-2-line"></i> <span>' . trans($element['name']) . '</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sideBar' . $element['id'] . '">
                        <ul class="nav nav-sm flex-column">
                            ' . $children . '
                        </ul>
                    </div>
                    </li>';
                    } else {
                        $html .= '<li class="nav-item">
                            <a href="' . (Route::has($element['route']) ? route($element['route']) : $element['route']) . '" class="nav-link menu-link">
                                <i class="' . $element['icon'] . ' align-middle me-1"></i> 
                                <span>' . trans($element['name']) . '</span>
                            </a>
                        </li>';
                    }
                } elseif ($place == 1) {
                    $html .= '<a class="dropdown-item" href="' . (Route::has($element['route']) ? route($element['route']) : $element['route']) . '">
                                <i class="' . $element['icon'] . ' text-muted fs-16 align-middle me-1"></i> 
                                <span class="align-middle">' . $element['name'] . '</span>
                            </a>';
                }
            }
        }

        return $html;
    }
}

if (! function_exists('getRole')) {
    function getRole()
    {
        return auth()->user()->role->roles->name;
    }
}
