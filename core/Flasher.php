<?php

namespace core;

require_once '../core/AutoLoader.php';

class Flasher
{
    public static function setFlash($type, $message)
    {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message,
        ];
    }

    public static function setValidationError($field, $message)
    {
        $_SESSION['validationErrors'][$field] = $message;
    }

    public static function hasValidationError($field)
    {
        return isset($_SESSION['validationErrors'][$field]);
    }

    public static function getValidationError($field)
    {
        return $_SESSION['validationErrors'][$field] ?? null;
    }

    public static function flash()
    {
        if (isset($_SESSION['flash'])) {
            $message = $_SESSION['flash']['message'];
            $type = $_SESSION['flash']['type'];

            $bgColor = $type === 'success' ? 'bg-green-100' : 'bg-red-100';
            $borderColor = $type === 'success' ? 'border-green-400' : 'border-red-400';
            $textColor = $type === 'success' ? 'text-green-700' : 'text-red-700';

            echo '
            <div class="' . $bgColor . ' border ' . $borderColor . ' ' . $textColor . ' px-4 py-3 rounded flex justify-between items-center mb-4"
                role="alert">
                <div>
                    <strong class="font-bold capitalize">' . ucfirst($type) . '!</strong>
                    <span class="block sm:inline">' . $message . '</span>
                </div>
                <button onclick="closeAlert()">
                    <span>
                        <svg class="fill-current h-6 w-6 ' . $textColor . '" role="button" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <title>Close</title>
                            <path
                                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                        </svg>
                    </span>
                </button>
            </div>
            ';
            unset($_SESSION['flash']);
        }

        if (isset($_SESSION['validationErrors'])) {
            unset($_SESSION['validationErrors']);
        }
    }
}
