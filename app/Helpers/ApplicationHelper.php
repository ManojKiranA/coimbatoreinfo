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
use Illuminate\Support\Str;
use Illuminate\Support\Collection;


use App\Helpers\BladeHelper;



class ApplicationHelper
{
	

        public static function toDropDown($modelName='',$nameSpace='',$optionDisplayField ='',$optionValueField ='',$placeHolderText='')
        {

            $currentModel =    static::convertVariableToModelName($modelName,$nameSpace);
            $listFiledValues = $currentModel::select($optionDisplayField,$optionValueField)->get();
            $selectArray = [];
            $selectArray[null] = $placeHolderText;
            foreach ($listFiledValues as $listFiledValue) 
            {
                $selectArray[$listFiledValue->$optionValueField] = $listFiledValue->$optionDisplayField;
            }
            return $selectArray;

        }

        public static function convertVariableToModelName($modelName='',$nameSpace='')
        {
            //if the given name space iin array the implode to string with \\
            if (is_array($nameSpace))
            {
                $nameSpace =  implode('\\', $nameSpace);
            }
            //by default laravel ships with name space App so while is $nameSpace is not passed considering the
            // model namespace as App
            if (empty($nameSpace) || is_null($nameSpace) || $nameSpace === "") 
            {                
               $modelNameWithNameSpace = "App".'\\'.$modelName;
            }
            //if you are using custom name space such as App\Models\Base\Country.php
            //$namespce must be ['App','Models','Base']
            if (is_array($nameSpace)) 
            {
                $modelNameWithNameSpace = $nameSpace.'\\'.$modelName;
                
            }
            //if you are passing Such as App in name space
            elseif (!is_array($nameSpace) && !empty($nameSpace) && !is_null($nameSpace) && $nameSpace !== "") 
            {
                $modelNameWithNameSpace = $nameSpace.'\\'.$modelName;
                 
            }
            //if the class exist with current namespace convert to container instance.
            if (class_exists($modelNameWithNameSpace)) 
            {
                    // $currentModelWithNameSpace = Container::getInstance()->make($modelNameWithNameSpace);
                    // use Illuminate\Container\Container;
                    $currentModelWithNameSpace = app($modelNameWithNameSpace);
            }
            //else throw the class not found exception
            else
            {
                throw new \Exception("Unable to find Model : $modelName With NameSpace $nameSpace", E_USER_ERROR);
            }

            return $currentModelWithNameSpace;
        }

        public static function generateSeriesNumberWithPrefix($modelName = '',$nameSpace='', $autogenField = '', $autogenStart = '', $autogenPrefix = '')
        {
            $currentModel = static::convertVariableToModelName($modelName,$nameSpace);
            
            $listFiledValues = $currentModel::select($autogenField)->get();

            if ($listFiledValues->isNotEmpty())
            {
                foreach($listFiledValues as $listFiledValue)
                {
                    $eachListarray = $listFiledValue->$autogenField;
                    $totalListArrays[] = $eachListarray;
                }

                foreach($totalListArrays as $totalListArray)
                {
                    $stringRemovedEachListArray = substr($totalListArray,strlen($autogenPrefix));
                    $stringRemovedTotalListArray[] = $stringRemovedEachListArray;
                }

                $maximumValue = max($stringRemovedTotalListArray);

                $generatedAutogen = $autogenPrefix.++$maximumValue;

                return $generatedAutogen;
            }
            elseif ($listFiledValues->isEmpty())
            {
                $generatedAutogen = $autogenPrefix.$autogenStart;
                return $generatedAutogen;
            }
        }

       public static function getVersion($versionNo='')
        {

            if (!$versionNo) 
            {
                return '1.0';
            }
                       
            for ($i=1; $i <= 1 ; $i++) 
            { 
                for ($j=0; $j <= 100; $j++) 
                { 
                    $versionArray[] =  $i.'.'.$j;        
                }
            }
            $currentVersionKey = array_search($versionNo, $versionArray,true);

            $nextVersion = $currentVersionKey + 1;

            
            return $versionArray[$nextVersion];

            
        }

        public static function getDocumentVersionHistory($documentAutogen='')
        {
            $jsv = 'javascript:void(0);';
            
            $docAutogenValue = Crypt::decrypt($documentAutogen);

            $versionQueryCollection = DocDocumentVersion::where('ver_document_autogenerated_id','=' ,$docAutogenValue)
                                                            ->orderBy('ver_document_version_no', 'DESC')
                                                            ->with('versionCreatedByName')
                                                            ->get();


            if ($versionQueryCollection->isEmpty()) 
            {
                return '';
            }

            foreach ($versionQueryCollection as $versionQueryValue) 
            {
                $htmlVersionTree[] = 
                                    '
                                <ul class="timeline">
                                    <li>
                                        <a href="'.$jsv.'" class="float-left">
                                        '.$versionQueryValue->versionCreatedByName['name'].' --
                                        </a>
                                        <a target="_blank" href="'.url('downloadDocumentReversion/'.$versionQueryValue->id).'">
                                        '.$versionQueryValue->ver_document_version_no.' --
                                        <i class="fa fa-download"></i> 
                                        </a> 
                                        
                                        <a href="'.$jsv.'" class="float-right">
                                        '.static::formatDocumentTimeStamp($versionQueryValue->created_at).'
                                        </a>
                                        <p>
                                        '.$versionQueryValue->ver_document_changes_description.'
                                        </p>
                                    </li>
                                </ul>

                                    ';
            }
            return new HtmlString(implode('',$htmlVersionTree));
        }

        public static function  formatDocumentTimeStamp($timeString='')
        {
            $newFormat = 'l jS \of F Y h:i:s A';

             $toTimeString = strtotime($timeString);

            return date($newFormat, $toTimeString);
        }

        public static function getLatestVersionNumber($autogenID='',$defaultField='',$fieldName='')
        {
            $versionQueryCollection = DocDocumentVersion::where('ver_document_autogenerated_id','=' ,$autogenID)
                                                            ->orderBy('ver_document_version_no', 'DESC')
                                                            ->with('versionCreatedByName')
                                                            ->get();


            if ($versionQueryCollection->isEmpty()) 
            {
                return $defaultField;
            }
            elseif($versionQueryCollection->isNotEmpty())
            {
                $fileLatestQuery = $versionQueryCollection->first();
                return $fileLatestQuery->$fieldName;
            }
        }

        public static  function getApprovalHistory($documentAutogen='',$defaultText='Pending for Approval',$version='')
        {
            $jsv = 'javascript:void(0);';
            $docAutogenValue = Crypt::decrypt($documentAutogen);
            $docStatusCollection = DocDocumentStatus::where('doc_status_autogen','=',$docAutogenValue)
                                                    ->with('docStatusUserName')
                                                    ->get();

            if ($docStatusCollection->isEmpty()) 
            {
                return '';
            }
            $t = 'test';
            

            foreach ($docStatusCollection as $docStatusValue) 
            {
                $userName = $docStatusValue->docStatusUserName['name'];
                $createdAt = static::formatDocumentTimeStamp($docStatusValue->created_at);
                $statusReason = BladeHelper::printIfEmpty($docStatusValue->doc_status_reason,$defaultText);
                $htmlVersionTree[] = 
                                    '
                                <ul class="timeline">
                                    <li>
                                        <a href="'.$jsv.'" class="float-left">
                                        '.$userName.' --
                                        </a>                                        
                                        
                                        <a  href="'.$jsv.'">
                                        '.$docStatusValue->doc_status_value.'--'.$docStatusValue->doc_version_id.'
                                        </a> 
                                        
                                        <a href="'.$jsv.'" class="float-right">
                                        '.static::formatDocumentTimeStamp($docStatusValue->created_at).'
                                        </a>
                                        <p>
                                        '.$statusReason.'
                                        </p>

                                    </li>
                                </ul>
                                ';
            }

            return new HtmlString(implode('',$htmlVersionTree));

        }

        public static function getUserNofification($userId='')
        {
            $approvedStatus = 'Approved';
            $rejectedStatus = 'Rejected';
            $pendingStatus = 'Pending';
            $createdStatus = 'Created';

            $whereConditionArray = [
                                    ['doc_status_user_id','=',$userId],
                                    ['doc_status_value','=',$pendingStatus],
                                    ['is_read','=','1'],

                                   ];
            $defaultNofification = '
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Notification(0)
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                  <a class="dropdown-item" href="#">No Notifiction</a>
                                </div>';

            $currentUsersQuery = DocDocumentStatus::where($whereConditionArray)->get();

            if ($currentUsersQuery->isEmpty()) 
            {
                return new HtmlString($defaultNofification);
            }
            else
            {
                $notifictionCount = $currentUsersQuery->count();

                $headingTag[] = '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Notification('.$notifictionCount.')
                                 </a>
                                 ';
                $headingDivTagStart[] = '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                $headingDivTagEnd[] = '</div>';

                foreach ($currentUsersQuery as $currentUserQueryKey => $currentUserQueryValue) 
                {

                    $htmlNotification[] = '
                                    <a class="dropdown-item" target="_blank" href="'.url('seeDocumentCreatedNotification/'.$currentUserQueryValue->id).'">
                                        '.$currentUserQueryValue->doc_status_autogen.'--'.$currentUserQueryValue->doc_status_value.' --
                                        <i class="fa fa-eye"></i> 
                                    </a> 
                                ';    
                }

                $finalHtml = array_merge($headingTag,$headingDivTagStart,$htmlNotification,$headingDivTagEnd);

            }

            return new HtmlString(implode('',$finalHtml));
        }

        public static function sqlWithParm($query)
        {

            $toSql = $query->toSql();

            $replceInSql = str_replace('?', '%s',$toSql);

            $collectMethod = collect($query->getBindings())->map(function($binding){return is_numeric($binding) ? $binding : "'{$binding}'";});

            $collectMethodToarray = $collectMethod->toArray();

            $finalsql = vsprintf( $replceInSql,  $collectMethodToarray);

            return $finalsql;
        }

        public static function getPropertyOfDocuments($autoGenId='',$propertyField='')
        {
            $autoGenId = Crypt::decrypt($autoGenId);
            $whereConditionArray =  [
                                        ['document_autogen','=',$autoGenId],
                                    ];
            $documentQuery = DocDocument::
                                        where($whereConditionArray)
                                        ->select($propertyField)
                                        ->first()
                                        ->$propertyField;
            return $documentQuery;

        }

        public static function getDocumentCreatedUserProp($autoGenId='',$fieldName='')
        {
            $dcoUserQuery = DocDocument::where('document_autogen' ,'=',$autoGenId)
                                            ->with('createdBy')
                                            ->first();
                                            
            switch ($fieldName) 
            {
                case 'name':
                    return $dcoUserQuery->createdBy['name'];
                    break;
                case 'email':
                    return $dcoUserQuery->createdBy['email'];
                    break;
                case 'document_department_id':
                    return $dcoUserQuery->$fieldName;
                    break;
                case 'id':
                    return $dcoUserQuery->$fieldName;
                    break;
                
                default:
                    # code...
                    break;
            }
        }

        public static function dateRangeFetch($modelName='',$nameSpace='',$timeFrame='', $tableField='created_at', $dateString='')
        {

            $carbonObj = new \Carbon\Carbon;

            //if the given name space iin array the implode to string with \\
            if (is_array($nameSpace))
            {
                $nameSpace =  implode('\\', $nameSpace);
            }
            //by default laravel ships with name space App so while is $nameSpace is not passed considering the
            // model namespace as App
            if (empty($nameSpace) || is_null($nameSpace) || $nameSpace === "") 
            {                
               $modelNameWithNameSpace = "App".'\\'.$modelName;
            }
            //if you are using custom name space such as App\Models\Base\Country.php
            //$namespce must be ['App','Models','Base']
            if (is_array($nameSpace)) 
            {
                $modelNameWithNameSpace = $nameSpace.'\\'.$modelName;
                
            }
            //if you are passing Such as App in name space
            elseif (!is_array($nameSpace) && !empty($nameSpace) && !is_null($nameSpace) && $nameSpace !== "") 
            {
                $modelNameWithNameSpace = $nameSpace.'\\'.$modelName;
                 
            }
            //if the class exist with current namespace convert to container instance.
            if (class_exists($modelNameWithNameSpace)) 
            {
                    // $currModWitNamSpac = Container::getInstance()->make($modelNameWithNameSpace);
                    // use Illuminate\Container\Container;
                    $currModWitNamSpac = app($modelNameWithNameSpace);
            }
            //else throw the class not found exception
            else
            {
                throw new \Exception("Unable to find Model : $modelName With NameSpace $nameSpace", E_USER_ERROR);
            }

            if (empty($tableField) || is_null($tableField) || $tableField === "") 
            {                
               $tableField = 'created_at';
            }

            //convert to uppercase if the passed timeframe
            $timeFrame  = strtoupper($timeFrame);
            //creating the array which can automatically pass the data to date
            $selftimeFrame  = [
                                'TODAY','TOMORROW','YESTERDAY','STARTOFDAY','CURRENTMONTH',
                                'STARTOFWEEK','CURRENTYEAR','ENDOFDAY','ENDOFWEEK','STARTOFMONTH',
                                'ENDOFMONTH','STARTOFYEAR','ENDOFYEAR','STARTOFDECADE','ENDOFDECADE',
                                'STARTOFCENTURY','ENDOFCENTURY'
                              ];
            //if the user is passing value except in $selftimeFrame array values 
            if (empty($dateString) || $dateString === null || $dateString === "") 
            {
                if(!in_array($timeFrame,$selftimeFrame))
                {                   
                   throw new \Exception("Enter dateString for $timeFrame", E_USER_ERROR);
                }
            }
        switch ($timeFrame) 
        {

            //success when $timeFrame is TODAY
            case 'TODAY':
                    $modSqlQuery = $currModWitNamSpac::whereDate($tableField,'=',$carbonObj->today());
                break;
            //success when $timeFrame is TOMORROW
            case 'TOMORROW':
                $modSqlQuery = $currModWitNamSpac::whereDate($tableField,'=',$carbonObj->tomorrow());
                break;
            //success when $timeFrame is YESTERDAY
            case 'YESTERDAY':
                $modSqlQuery = $currModWitNamSpac::whereDate($tableField,'=',$carbonObj->yesterday());
                break;
            //success when $timeFrame is STARTOFDAY
            case 'STARTOFDAY':
                $modSqlQuery = $currModWitNamSpac::where($tableField,'=',$carbonObj->startOfDay());
                break;
            //success when $timeFrame is ENDOFDAY
            case 'ENDOFDAY':
                $modSqlQuery = $currModWitNamSpac::where($tableField,'=',$carbonObj->endOfDay());
                break;
            //success when $timeFrame is STARTOFWEEK
            case 'STARTOFWEEK':
                $modSqlQuery = $currModWitNamSpac::where($tableField,'=',$carbonObj->startOfWeek());
                break;
            //success when $timeFrame is ENDOFWEEK
            case 'ENDOFWEEK':
                $modSqlQuery = $currModWitNamSpac::where($tableField,'=',$carbonObj->endOfWeek());
                break;
            //success when $timeFrame is STARTOFMONTH
            case 'STARTOFMONTH':
                $modSqlQuery = $currModWitNamSpac::where($tableField,'=',$carbonObj->startOfMonth());
                break;
            //success when $timeFrame is ENDOFMONTH
            case 'ENDOFMONTH':
                $modSqlQuery = $currModWitNamSpac::where($tableField,'=',$carbonObj->endOfMonth());
                break;
            //success when $timeFrame is STARTOFYEAR
            case 'STARTOFYEAR':
                $modSqlQuery = $currModWitNamSpac::where($tableField,'=',$carbonObj->startOfYear());
                break;
            //success when $timeFrame is ENDOFYEAR
            case 'ENDOFYEAR':
                $modSqlQuery = $currModWitNamSpac::where($tableField,'=',$carbonObj->endOfYear());
                break;
            //success when $timeFrame is STARTOFDECADE
            case 'STARTOFDECADE':
                $modSqlQuery = $currModWitNamSpac::where($tableField,'=',$carbonObj->startOfDecade());
                break;
            //success when $timeFrame is ENDOFDECADE
            case 'ENDOFDECADE':
                $modSqlQuery = $currModWitNamSpac::where($tableField,'=',$carbonObj->endOfDecade());
                break;
            //success when $timeFrame is STARTOFCENTURY
            case 'STARTOFCENTURY':
                $modSqlQuery = $currModWitNamSpac::where($tableField,'=',$carbonObj->startOfCentury());
                break;
            //success when $timeFrame is ENDOFCENTURY
            case 'ENDOFCENTURY':
                $modSqlQuery = $currModWitNamSpac::where($tableField,'=',$carbonObj->endOfCentury());
                break;
            //success when $timeFrame is CURRENTYEAR
            case 'CURRENTYEAR':
                $modSqlQuery = $currModWitNamSpac::whereYear($tableField, '=', date('Y'));
                break;
            //success when $timeFrame is CURRENTMONTH
            case 'CURRENTMONTH':
                $modSqlQuery = $currModWitNamSpac::whereMonth($tableField, '=', date('m'));
                break;
            //success when $timeFrame is DAY
            case 'DAY':
                $modSqlQuery = $currModWitNamSpac::whereDay($tableField,'=',date('d', strtotime($dateString)));
                break;
            //success when $timeFrame is MONTH
            case 'MONTH':
                $modSqlQuery = $currModWitNamSpac::whereMonth($tableField, '=', date('m', strtotime($dateString)));
                break;
            //success when $timeFrame is YEAR
            case 'YEAR':
                $modSqlQuery = $currModWitNamSpac::whereYear($tableField, '=', date('Y', strtotime($dateString)));
                break;
            default:
            $selftimeFrameList = implode(',', $selftimeFrame);
            throw new \Exception("Time frame doesn't matches with any of the options  $selftimeFrameList", E_USER_ERROR);
        }
        return $modSqlQuery->get();
        
    }

    public static function getFullVersionHistory($documentAutogen='')
    {
        // getDocumentVersionHistory
        $jsv = 'javascript:void(0);';
            
        $docAutogenValue = Crypt::decrypt($documentAutogen);

        $mainDocQueryColl = DocDocument::where('document_autogen','=',$docAutogenValue)
                                        ->with('createdBy')
                                        ->get();

        

        foreach ($mainDocQueryColl as $mainDocQueryValue) 
            {
                $htmlVersionTreeV1[] = 
                                    '
                                
                                    <li>
                                        <a href="'.$jsv.'" class="float-left">
                                        '.$mainDocQueryValue->createdBy['name'].' --
                                        </a>
                                        <a target="_blank" href="'.url('downloadDocumentFileMain/'.$mainDocQueryValue->id).'">
                                        '.$mainDocQueryValue->document_version_no.' --
                                        <i class="fa fa-download"></i> 
                                        </a> 
                                        
                                        <a href="'.$jsv.'" class="float-right">
                                        '.static::formatDocumentTimeStamp($mainDocQueryValue->created_at).'
                                        </a>
                                        <p>
                                        '.$mainDocQueryValue->document_description.'
                                        </p>
                                    </li>
                                

                                    ';
            }

            

            $versionQueryCollection = DocDocumentVersion::where('ver_document_autogenerated_id','=' ,$docAutogenValue)
                                                            ->orderBy('ver_document_version_no', 'DESC')
                                                            ->with('versionCreatedByName')
                                                            ->get();


            $htmlVersionTreeAll[] = '';
            if ($versionQueryCollection->isNotEmpty()) 
            {

                foreach ($versionQueryCollection as $versionQueryValue) 
                {
                    $htmlVersionTreeAll[] = 
                                        '
                                    
                                        <li>
                                            <a href="'.$jsv.'" class="float-left">
                                            '.$versionQueryValue->versionCreatedByName['name'].' --
                                            </a>
                                            <a target="_blank" href="'.url('downloadDocumentReversion/'.$versionQueryValue->id).'">
                                            '.$versionQueryValue->ver_document_version_no.' --
                                            <i class="fa fa-download"></i> 
                                            </a> 
                                            
                                            <a href="'.$jsv.'" class="float-right">
                                            '.static::formatDocumentTimeStamp($versionQueryValue->created_at).'
                                            </a>
                                            <p>
                                            '.$versionQueryValue->ver_document_changes_description.'
                                            </p>
                                        </li>
                                    

                                        ';
                }
                

            }            

            $startUl[] = '<ul class="timeline">';
            $endUl[] = '</ul>';

            $totalHtml = array_merge($startUl,$htmlVersionTreeV1,$htmlVersionTreeAll,$endUl);

            return new HtmlString(implode('', $totalHtml));



    }

    public static    function convertToFormattedDate($dateString='',$dateFormat='')
    {
        $newFomattedDate = false;
            
        $dateTimeConsObj = new \DateTime($dateString);

        $newFormatWithTime = $dateTimeConsObj->format('Y-m-d H:i:s');

        $on = '\o\n';
        $at = '\a\t';
        $of = '\o\f';

        $dateFormatArray = 
                            [
                                // 1 => 'l jS '.$of.' F Y h:i:s A',

                                1 => 'M j, Y',

                                

                                2 => 'l jS '.$on.' F Y h-i-s A',

                                3 => 'Y-m-d H:i:s',

                                4 => 'd/m/Y H:i:s',

                                5 => 'd/m/y',

                                6 => 'g:i A',

                                7 => 'G:ia',

                                8 => 'g:ia '.$on.' l jS F Y',

                                9 => 'h:i A',
                            ];

        if (in_array($dateFormat, array_flip($dateFormatArray))) 
        {
            $toTimeString = strtotime($newFormatWithTime);

            $newFomattedDate = date($dateFormatArray[$dateFormat], $toTimeString);

        return $newFomattedDate;
        }        
    }

    public static function cutParagraphString($string='', $maxStringLength='',$fullWordsOnly = true, $addEllipsis = true) 
    {
        //geting the length of the string
        $stringLength = strlen($string); 

        $addEllipsis ==true ?  $addEllipsis ='...' : $addEllipsis ='';

        $subStrString = substr($string,0,$maxStringLength);
        
        if ($fullWordsOnly == false) 
        {
            if($stringLength > $maxStringLength) 
            {
              return $subStrString.$addEllipsis;
            }
            return $string;
        }

        if ($fullWordsOnly == true) 
        {
            $substrStringStrpos = substr($subStrString,0,strrpos($subStrString," "));

            if($stringLength > $maxStringLength) 
            {
                return $substrStringStrpos.$addEllipsis;
            }
            return $string;
        }
        

    }

    public static function getFirstLast($string='',$orgOnF=7,$orgOnB=-11,$maskedString='.',$maskRepeat=3)
    {

        if (strlen($string) <= 21) 
        {
            return $string;
        }
        $firstPartString = mb_substr($string, 0 ,$orgOnF);

        $secondPartString = mb_substr($string,$orgOnB);

        $maskedString = str_repeat($maskedString, $maskRepeat);

        $finalResult = $firstPartString.$maskedString.$secondPartString;

        return $finalResult;
        
    }
    

        


}
?>