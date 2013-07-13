<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * NetCommons初期化実行アクションクラス
 *
 * @package   NetCommons Extensions
 * @author    WithOne Company Limited.
 * @copyright 2013 WithOne Company Limited.
 * @project   NetCommons Extensions
 * @access    public
 */
class Balus_Action_Main_Destroy extends Action
{
	// リクエストパラメータを受け取るため

	// 使用コンポーネントを受け取るため
	var $db = null;

	// 値をセットするため

	/**
	 * execute実行
	 *
	 * @access  public
	 */
	function execute()
	{
		// uploads配下のファイルを削除
		exec(BALUS_FILE_DELETE_CMD, $output, $returnCode);
		if ($returnCode !== 0) {
			return 'error';
		}

		// templates_c配下のファイルを削除
		exec(BALUS_TEMPLATES_C_DELETE_CMD, $output, $returnCode);
		if ($returnCode !== 0) {
			return 'error';
		}

		// DBを削除
		$dsn = $this->db->getDsn();
		$dsnArr = explode('/', $dsn);
		if (count($dsnArr) != 4) {
			return 'error';
		}
		$dbName = $dsnArr[3];
		$sql = ' DROP DATABASE '.$dbName;
		$result = $this->db->execute($sql);
		if ($result === false) {
			return 'error';
		}

		@copy(BALUS_INSTALLINC_DIR.'/'.BALUS_INSTALLINC_FILENAME, BALUS_INSTALLINC_DIR.'/'.BALUS_INSTALLINC_FILENAME.date('YmdHis'));
		// install.inc.phpに書き込み権限を付与
		if (!@chmod(BALUS_INSTALLINC_DIR.'/'.BALUS_INSTALLINC_FILENAME, 0777)) {
			return 'error';
		}

		return 'success';
	}
}
?>
