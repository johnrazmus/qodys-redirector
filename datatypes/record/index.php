<?php
class qodyDatatype_RedirectorRecords extends QodyDataType
{
	function __construct()
    {
        $this->SetOwner( func_get_args() );
		$this->m_raw_file = __FILE__;
		
		$this->m_table_slug = 'records';
		
        parent::__construct();
    }
	
}
?>