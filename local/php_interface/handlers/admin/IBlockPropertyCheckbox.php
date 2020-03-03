<?

namespace local\handlers\admin;

global $MESS;
$MESS['IBLOCK_PROP_CHECKBOX_DESC'] = 'Флажок';
$MESS['IBLOCK_PROP_CHECKBOX_YES']  = 'Да';
$MESS['IBLOCK_PROP_CHECKBOX_NO']   = 'Нет';
$MESS['IBLOCK_PROP_CHECKBOX_NA']   = '(любой)';

class IBlockPropertyCheckbox
{
    function GetUserTypeDescription()
    {
        return array(
            'PROPERTY_TYPE'             => 'S',
            'USER_TYPE'                 => 'Checkbox',
            'DESCRIPTION'               => GetMessage('IBLOCK_PROP_CHECKBOX_DESC'),
            'GetAdminListViewHTML'      => array(__CLASS__, 'GetTextVal'),
            'GetPublicViewHTML'         => array(__CLASS__, 'GetTextVal'),
            'GetPropertyFieldHtml'      => array(__CLASS__, 'GetPropertyFieldHtml'),
            'GetPropertyFieldHtmlMulty' => array(__CLASS__, 'GetPropertyFieldHtml'),
            'AddFilterFields'           => array(__CLASS__, 'AddFilterFields'),
            'GetPublicFilterHTML'       => array(__CLASS__, 'GetFilterHTML'),
            //  It seems it doesn't work :(
            //  Another Bitrix bug?
            'GetAdminFilterHTML'        => array(__CLASS__, 'GetFilterHTML'),
            'ConvertToDB'               => array(__CLASS__, 'ConvertToFromDB'),
            'ConvertFromDB'             => array(__CLASS__, 'ConvertToFromDB'),
            'GetSearchContent'          => array(__CLASS__, 'GetSearchContent'),
        );
    }

    function GetTextVal($arProperty, $value, $strHTMLControlName)
    {
        return $value['VALUE'] == 'Y' ? GetMessage('IBLOCK_PROP_CHECKBOX_YES') : GetMessage('IBLOCK_PROP_CHECKBOX_NO');
    }

    function GetPropertyFieldHtml($arProperty, $value, $strHTMLControlName)
    {
        //  if the field is multiple we have to force it to singular
        if ( ! array_key_exists('VALUE', $value) && $arProperty['MULTIPLE'] == 'Y') {
            $value = array_shift($value);
        }

        return '<input type="hidden" name="' . $strHTMLControlName['VALUE'] . '" value="N" /><input type="checkbox" name="' . $strHTMLControlName['VALUE'] . '" value="Y" ' . ($value['VALUE'] == 'Y' ? 'checked="checked"' : '') . '/>';
    }

    function AddFilterFields($arProperty, $strHTMLControlName, &$arFilter, &$filtered)
    {
        if (isset($_REQUEST[$strHTMLControlName['VALUE']])) {
            $prefix                                              = $_REQUEST[$strHTMLControlName['VALUE']] == 'Y' ? '=' : '!=';
            $arFilter[$prefix . 'PROPERTY_' . $arProperty['ID']] = 'Y';
            $filtered                                            = true;
        }
    }

    function GetFilterHTML($arProperty, $strHTMLControlName)
    {
        $select = '<select name="' . $strHTMLControlName['VALUE'] . '">
            <option value="" >' . GetMessage('IBLOCK_PROP_CHECKBOX_NA') . '</option>
            <option value="Y" ' . ($_REQUEST[$strHTMLControlName['VALUE']] == 'Y' ? 'selected="selected"' : '') . '>' . GetMessage('IBLOCK_PROP_CHECKBOX_YES') . '</option>
            <option value="N" ' . ($_REQUEST[$strHTMLControlName['VALUE']] == 'N' ? 'selected="selected"' : '') . '>' . GetMessage('IBLOCK_PROP_CHECKBOX_NO') . '</option>
        </select>';

        return $select;
    }

    function GetSearchContent($arProperty, $value, $strHTMLControlName)
    {
        $propId = $arProperty;  //  $arProperty contains property id, not array.
        //  Is it bug in Bitrix, isn't it?
        $propParams = CIBlockProperty::GetByID($propId)->Fetch();

        return $value['VALUE'] == 'Y' ? $propParams['NAME'] : '';
    }

    function ConvertToFromDB($arProperty, $value)
    {
        $value['VALUE'] = $value['VALUE'] == 'Y' ? 'Y' : 'N';

        return $value;
    }

    function GetLength($arProperty, $value)
    {
        return 1;  //  checkbox is always filled
    }
}
