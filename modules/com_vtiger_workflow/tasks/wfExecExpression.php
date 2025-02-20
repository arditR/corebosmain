<?php
/*************************************************************************************************
 * Copyright 2020 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Customizations.
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
 *************************************************************************************************
 *  Author       : JPL TSolucio, S. L.
 *************************************************************************************************/
require_once 'modules/com_vtiger_workflow/VTEntityCache.inc';
require_once 'modules/com_vtiger_workflow/VTWorkflowUtils.php';
require_once 'modules/com_vtiger_workflow/expression_engine/include.inc';

class wfExecExpression extends VTTask {
	public $executeImmediately = true;
	public $queable = false;
	public $wfexeexps;

	public function getFieldNames() {
		return array('wfexeexps');
	}

	public function doTask(&$entity) {
		global $logbg;
		$logbg->debug('> wfExecExpression');
		if (!empty($this->wfexeexps)) {
			$wfexps = json_decode($this->wfexeexps, true);
			foreach ($wfexps as $exp) {
				if ($exp['typ']=='rawtext') {
					$exprEvaluation = $exp['exp'];
				} else {
					$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($exp['exp'])));
					$expression = $parser->expression();
					$exprEvaluater = new VTFieldExpressionEvaluater($expression);
					$exprEvaluation = $exprEvaluater->evaluate($entity);
				}
				if (!empty($exp['var'])) {
					$logbg->debug('(wfExecExpression)', [$exp, $exprEvaluation]);
					$entity->WorkflowContext[$exp['var']] = $exprEvaluation;
				}
			}
		} else {
			$logbg->debug('(wfExecExpression) workflow expression is empty');
		}
		$logbg->debug('< wfExecExpression');
	}
}
?>