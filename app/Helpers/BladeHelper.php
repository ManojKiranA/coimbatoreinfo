<?php
namespace App\Helpers;

use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;

class BladeHelper
{

    public static function printIfEmpty($value = '', $defaultDisplayValue = '')
    {

        if (!empty($value) || !is_null($value)) {
            return $value;
        } elseif (empty($value) || is_null($value)) {
            if (!empty($defaultDisplayValue) || !is_null($defaultDisplayValue)) {
                return $defaultDisplayValue;
            } elseif (!empty($defaultDisplayValue) || !is_null($defaultDisplayValue)) {
                return 'Empty';
            }
        }
    }

    public static function toDropDown($modelName = '', $nameSpace = '', $optionDisplayField = '', $optionValueField = '', $placeHolderText = '')
    {

        $currentModel =    static::convertVariableToModelName($modelName, $nameSpace);
        $listFiledValues = $currentModel::select($optionDisplayField, $optionValueField)->get();
        $selectArray = [];
        $selectArray[null] = $placeHolderText;
        foreach ($listFiledValues as $listFiledValue) {
            $selectArray[$listFiledValue->$optionValueField] = $listFiledValue->$optionDisplayField;
        }
        return $selectArray;
    }

    public static function convertVariableToModelName($modelName = '', $nameSpace = '')
    {
        if (empty($nameSpace) || is_null($nameSpace) || $nameSpace === "") {
            $modelNameWithNameSpace = "App" . '\\' . $modelName;
            return app($modelNameWithNameSpace);
        }

        if (is_array($nameSpace)) {
            $nameSpace = implode('\\', $nameSpace);
            $modelNameWithNameSpace = $nameSpace . '\\' . $modelName;
            return app($modelNameWithNameSpace);
        } elseif (!is_array($nameSpace)) {
            $modelNameWithNameSpace = $nameSpace . '\\' . $modelName;
            return app($modelNameWithNameSpace);
        }
    }

    /**
    * @function     tableActionButtons
    * @author       Manojkiran <manojkiran10031998@gmail.com>
    * @param        string  $fullUrl
    * @param        integer  $id
    * @param        string  $titleValue
    * @param        array  $buttonActions
    * @usage        Generates the buttons
    * @version      1.0
    **/
    /*
    NOTE:

    if you want to show tooltip you need the JQUERY JS and tooltip Javascript

    if you are not well in JavaScript Just Use My Function toolTipScript()



    |--------------------------------------------------------------------------
    | Generates the buttons
    |--------------------------------------------------------------------------
    |Generates the buttons while displaying the table data in laravel
    |when the project is bigger and if you are laravel expert you this.
    |But if you are the learner just go with basic
    |
    |Basically It Will generate the buttons for show edit delete record with the default
    |Route::resource('foo',FooController);
    |
    |//requirements
    |
    |//bootstrap --version (4.1.3)
    |//  <link rel="stylesheet"href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="" crossorigin="">
    |//fontawesome --version (5.6.0(all))
    |//<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.0/css/all.css" integrity="" crossorigin="">
    |
    |if you want to show tooltip you nee the jquery and tooltip you need these js and toottipscript javascript or use my function toolTipScript
    |
    |//jquery
    |// <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    |//popper js
    |// <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    |//bootstrap js
    |// <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    |
    |usage
    |option1:
    |tableActionButtons(url()->full(),$item->id,$item->name);
    |this will generate all the buttons
    |
    |option2:
    |tableActionButtons(url()->full(),$item->id,$item->name,['edit',delete]);
    |this will generate edit and delete the buttons
    |
    |option3:
    |tableActionButtons(url()->full(),$item->id,$item->name,['edit',delete,delete],'group');
    |this will generate all the buttons with button grouping
    |
    |option4:
    |tableActionButtons(url()->full(),$item->id,$item->name,['show','edit','delete'],'dropdown');
    |this will generate all the buttons with button dropdown
    |
    */

    public static  function tableActionButtons($fullUrl, $id, $titleValue, $buttonActions = ['show', 'edit', 'delete'], $buttonOptions = '', $encryptId = false)
    {
        $fullUrl = strtok($fullUrl, '?');
        if ($encryptId) {
            $id = Crypt::encrypt($id);
        }
        // dd(get_class_methods(HtmlString::class));

        //Value of the post Method
        $postMethod = 'POST';
        //if the application is laravel then csrf is used

        $token = csrf_token();

        //NON laravel application
        // if (function_exists('csrf_token'))
        // {
        //   $token = csrf_token();
        // }elseif (!function_exists('csrf_token'))
        // //else if the mcrypt id is used if the function exits
        //     {
        //         if (function_exists('mcrypt_create_iv'))
        //         {
        //             // if the mcrypt_create_iv id is used if the function exits the set the token
        //             $token = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
        //         }
        //         else{
        //             // elseopenssl_random_pseudo_bytes is used if the function exits the set the token
        //             $token = bin2hex(openssl_random_pseudo_bytes(32));
        //         }
        //     }

        //action button Value
        //(url()->full()) will pass the current browser url to the function[only aplicable in laravel]
        $urlWithId  = $fullUrl . '/' . $id;
        //Charset UsedByFrom
        $charset = 'UTF-8';

        // Start Delete Button Arguments
        //title for delete functions
        $deleteFunctionTitle = 'Delete';
        //class name for the deletebutton
        $deleteButtonClass = 'btn-delete btn btn-xs btn-danger';
        //Icon for the delete Button
        $deleteButtonIcon = 'fa fa-trash';
        //text for the delete button
        $deleteButtonText  = '';
        //dialog Which needs to be displayes while deleting the record
        $deleteConfirmationDialog = 'Are You Sure you wnat to delete ' . $titleValue;

        $deleteButtonTooltopPostion = 'top';
        // End Delete Button Arguments


        // Start Edit Button Arguments
        //title for Edit functions
        $editFunctionTitle = 'Edit';
        $editButtonClass = 'btn-delete btn btn-xs btn-primary';
        //Icon for the Edit Button
        $editButtonIcon = 'fa fa-edit';
        //text for the Edit button
        $editButtonText  = '';
        $editButtonTooltopPostion = 'top';
        // End Edit Button Arguments


        // Start Show Button Arguments
        //title for Edit functions
        $showFunctionTitle = 'Show';
        $showButtonClass = 'btn-delete btn btn-xs btn-primary';
        //Icon for the Show Button
        $showButtonIcon = 'fa fa-eye';
        //text for the Show button
        $showButtonText  = '';
        $showButtonTooltopPostion = 'top';
        // End Show Button Arguments
        //Start Arguments for DropDown Buttons
        $dropDownButtonName = 'Actions';
        //End Arguments for DropDown Buttons




        $showButton = '';
        $showButton .= '
                <a href="' . $fullUrl . '/' . $id . '"class="' . $showButtonClass . '"data-toggle="tooltip"data-placement="' . $showButtonTooltopPostion . '"title="' . $showFunctionTitle . '-' . $titleValue . '">
                    <i class="' . $showButtonIcon . '"></i> ' . $showButtonText . '
                </a>
            ';

        $editButton = '';
        $editButton .= '
                    <a href="' . $urlWithId . '/edit' . '"class="' . $editButtonClass . '"data-toggle="tooltip"data-placement="' . $editButtonTooltopPostion . '" title="' . $editFunctionTitle . '-' . $titleValue . '">
                        <i class="' . $editButtonIcon . '"></i> ' . $editButtonText . '
                    </a>
                ';


        $deleteButton = '';
        $deleteButton .= '
                    <form id="form-delete-row' . $id . '"  method="' . $postMethod . '" action="' . $urlWithId . '" accept-charset="' . $charset . '"style="display: inline" onSubmit="return confirm(&quot;' . $deleteConfirmationDialog . '&quot;)">
                        <input name="_method" type="hidden" value="DELETE">
                        <input name="_token" type="hidden" value="' . $token . '">
                        <input name="_id" type="hidden" value="' . $id . '">
                        <button type="submit"class="' . $deleteButtonClass . '"data-toggle="tooltip"data-placement="' . $deleteButtonTooltopPostion . '" title="' . $deleteFunctionTitle . '-' . $titleValue . '">
                            <i class="' . $deleteButtonIcon . '"></i>' . $deleteButtonText . '
                        </button>
                    </form>
                ';


        // $deleteButton = "<a href='index.php?page=de_activate_organization&action_id=$id' onClick=\"return confirm('Are you Sure to De Activate?')\"><span class='label label-success'>" ."Test" . "</span></a>";



        $actionButtons = '';

        foreach ($buttonActions as $buttonAction) {
            if ($buttonAction == 'show') {
                $actionButtons .= $showButton;
            }
            if ($buttonAction == 'edit') {
                $actionButtons .= $editButton;
            }
            if ($buttonAction == 'delete') {
                $actionButtons .= $deleteButton;
            }
        }
        if (empty($buttonOptions)) {
            return  new HtmlString($actionButtons);
        } elseif (!empty($buttonOptions)) {
            if ($buttonOptions == 'group') {

                $buttonGroup = '<div class="btn-group" role="group" aria-label="">
                    ' . $actionButtons . '
                    </div>';
                return new HtmlString($buttonGroup);
            } elseif ($buttonOptions == 'dropdown') {
                $dropDownButton  =
                    '<div class="dropdown">
                          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            ' . $dropDownButtonName . '
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          ' . $actionButtons . '
                          </div>
                        </div>
                        ';
                return new HtmlString($dropDownButton);
            } else {
                return  'only <code>group</code> and <code>dropdown</code> is Available ';
            }
        }
    }

    public static function toolTipScript()
    {
        $script = '';
        $script = '
        <script>
        $(function () {
            $(' . "'[data-toggle=" . '' . '"tooltip"]' . '' . "').tooltip()" . '
        })
        </script>';
        return new HtmlString($script);
    }

    public static function convertToSourceCode($string = '', $type = 'PHP', $returnType = false, $enableLineCount = true, $startingLineNumber = '1', $fontColor = '#666')
    {
        //http://php.net/manual/en/function.highlight-string.php#50069
        //using the highlight_string with the given string

        //uncomment below Line if you are in laravel

        $bladeSyntax = ['{{', '{{{', '{!!', '}}', '}}}', '!!}'];

        if ($type == 'LARAVEL') {
            $string = str_replace($bladeSyntax, '', $string);
        }

        $highlightString = highlight_string($string, true);

        $lineBreak = "\n";

        $replaceArray = array(
            '<font' => '<span',
            'color="' => 'style="color: ',
            '</font>' => '</span>',
            '<code>' => '',
            '</code>' => '',
            '<span style="color: #FF8000">' =>
            '<span style="color: ' . $fontColor . '">'
        );
        foreach ($replaceArray as $replaceArrayKey => $replaceArrayKeyValue) {
            $highlightString = str_replace($replaceArrayKey, $replaceArrayKeyValue, $highlightString);
        }
        // delete the first <span style="color:#000000;"> and the corresponding </span>
        $stringSubStr = substr($highlightString, 30, -8);

        $htmlArray      = explode('<br/>', $stringSubStr);

        $totalLines   = count($htmlArray);

        $htmlOutput           = '';

        $lineCounter  = 0;

        $lastLineNumber = $startingLineNumber + $totalLines;

        foreach ($htmlArray as $htmlArrayValue) {
            $htmlArrayValue = str_replace(chr(13), '', $htmlArrayValue);

            $current_line = $startingLineNumber + $lineCounter;

            if ($enableLineCount) {
                $htmlOutput .= '<span style="color:' . $fontColor . '">'
                    . str_repeat('&nbsp;', strlen($lastLineNumber) - strlen($current_line))
                    . $current_line
                    . ': </span>';
            }
            $htmlOutput .= $htmlArrayValue
                . '<br />' . $lineBreak;
            $lineCounter++;
        }
        $htmlOutput = '<code>' . $lineBreak . $htmlOutput . '</code>';

        if ($returnType) {
            return new HtmlString($htmlOutput);
        } else {
            echo new HtmlString($htmlOutput);
        }
    }

    public static function getStatusLabel($value = '')
    {
        $html = '<button type="button" class="btn btn-primary">Primary <span class="badge">7</span></button>';


        $successStatusArr =
            [
                array_merge(
                    static::convertToAllPossibeCases('Approved'),
                    static::convertToAllPossibeCases('Open')
                )

            ];

        $successStatus = static::flattenArray($successStatusArr);

        $unSuccessStatusArr =
            [
                array_merge(
                    static::convertToAllPossibeCases('Rejected'),
                    static::convertToAllPossibeCases('Closed')
                )

            ];

        $unSuccessStatus = static::flattenArray($unSuccessStatusArr);





        $neUnSuccessNoSuccessArr =
            [
                array_merge(
                    static::convertToAllPossibeCases('Pending')
                )

            ];

        $neUnSuccessNoSuccess = static::flattenArray($neUnSuccessNoSuccessArr);


        $successStatusLabel = 'success';
        $unSuccessStatusLabel = 'danger';
        $neUnSuccessNoSuccessLabel = 'warning';

        if (in_array($value, $successStatus)) {
            $html =  '<span class="label btn btn-' . $successStatusLabel . ' ">' . ucfirst($value) . '</span>';
        }

        if (in_array($value, $unSuccessStatus)) {
            $html =  '<span class="label btn btn-' . $unSuccessStatusLabel . ' ">' . ucfirst($value) . '</span>';
        }

        if (in_array($value, $neUnSuccessNoSuccess)) {
            $html =  '<span class="label btn btn-' . $neUnSuccessNoSuccessLabel . ' ">' . ucfirst($value) . '</span>';
        }

        return new HtmlString($html);
    }
    public static function convertToAllPossibeCases($string = '')
    {
        $availableMethods =
            [
                'ucfirst',
                'strtoupper',
                'strtolower',
                'lcfirst',

            ];
        foreach ($availableMethods as $availableMethodKey => $availableMethodValue) {
            $stringListArray[] = $availableMethodValue($string);
        }

        return array_unique($stringListArray);
    }

    public static function getConfirm($confirmString = '', $confirmValue = '')
    {
        $html = '';
        $html = 'onclick = "if (! confirm(' . "'" . $confirmString . $confirmValue . "')) { return false;}" . '"';
        return new HtmlString($html);
    }

    public static function flattenArray($array = '')
    {

        $recursiveIteratorArray = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($array));
        foreach ($recursiveIteratorArray as $recursiveIteratorArrayKey => $recursiveIteratorArrayValue) {
            $finalArray[] = $recursiveIteratorArrayValue;
        }
        return $finalArray;
    }

    public static function getActiveMenuArray($masterName = '')
    {
        $masterName = strtoupper($masterName);
        switch ($masterName) {
            case 'LOCATIONMASTER':
                $menuItems = ['cbeInfoLocationFroms', 'cbeInfoLocationTos'];
                return $menuItems;
                break;
            case 'BUSMASTER':
                $menuItems = [ 'cbeInfoBusTypes', 'cbeInfoBusNames', 'cbeInfoBusVias'];
                return $menuItems;
                break;

            default:
                # code...
                break;
        }
    }
}
