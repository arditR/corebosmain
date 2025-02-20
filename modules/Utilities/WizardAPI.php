<?php
/*************************************************************************************************
 * Copyright 2022 JPL TSolucio, S.L. -- This file is a part of coreBOS Customizations.
 * Licensed under the vtiger CRM Public License Version 1.1 (the "License"); you may not use this
 * file except in compliance with the License. You can redistribute it and/or modify it
 * under the terms of the License. JPL TSolucio, S.L. reserves all rights not expressly
 * granted by the License. coreBOS distributed by JPL TSolucio S.L. is distributed in
 * the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. Unless required by
 * applicable law or agreed to in writing, software distributed under the License is
 * distributed on an "AS IS" BASIS, WITHOUT ANY WARRANTIES OR CONDITIONS OF ANY KIND,
 * either express or implied. See the License for the specific language governing
 * permissions and limitations under the License. You may obtain a copy of the License
 * at <http://corebos.org/documentation/doku.php?id=en:devel:vpl11>
 *************************************************************************************************/
include_once 'include/ListView/GridUtils.php';
include_once 'modules/Vtiger/WizardClass.php';

$wizardaction = empty($_REQUEST['wizardaction']) ? 'listview' : $_REQUEST['wizardaction'];
$formodule = isset($_REQUEST['formodule']) ? vtlib_purify($_REQUEST['formodule']) : '';
$wizard = new WizardActions($formodule);
switch ($wizardaction) {
	case 'MassCreate':
		echo json_encode($wizard->MassCreate());
		break;
	case 'Mapping':
		echo json_encode($wizard->Mapping());
		break;
	case 'Delete':
	case 'Session':
	case 'Duplicate':
	case 'CustomCreate':
		echo json_encode($wizard->HandleRequest());
		break;
	case 'listview':
	default:
		echo $wizard->Grid();
		break;
}