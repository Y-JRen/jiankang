<?php

class Admin_Models_DB_InStock
{
	/**
     * Zend_Db
     * @var    Zend_Db
     */
	private $_db = null;
	
	/**
     * page size
     * @var    int
     */
	private $_pageSize = null;
	
	/**
     * table name
     * @var    string
     */
	private $_table_instock = 'shop_instock';
	private $_table_instock_plan = 'shop_instock_plan';
	private $_table_instock_detail = 'shop_instock_detail';
	private $_table_supplier = 'shop_supplier';
	private $_table_stock_status = 'shop_stock_status';
	private $_table_product = 'shop_product';
	private $_table_product_batch = 'shop_product_batch';
	private $_table_goods = 'shop_goods';
	private $_table_goods_cat = 'shop_goods_cat';
	private $_table_stock_op = 'shop_stock_op';
	private $_table_purchase_payment = 'shop_purchase_payment';
	
	/**
     * Creates a db instance.
     *
     * @param  void
     * @return void
     */
	public function __construct()
	{
		$this -> _db = Zend_Registry::get('db');
		$this -> _pageSize = Zend_Registry::get('config') -> view -> page_size;
	}
	
	/**
     * 获取数据集
     *
     * @param    string    $where
     * @param    string    $fields
     * @param    string    $orderBy
     * @param    int       $page
     * @param    int       $pageSize
     * @return   array
     */
	public function get($where = null, $fields = '*', $page = null, $pageSize = null, $orderBy = null)
	{
		$pageSize = ((int)$pageSize > 0) ? (int)$pageSize : $this -> _pageSize;
		
		if ($page != null) {
		    $offset = ($page-1)*$pageSize;
		    $limit = "LIMIT $pageSize OFFSET $offset";
		}
		
		if ($where != null) {
			$whereSql = "WHERE $where";
		}
		
		if ($orderBy != null){
			$orderBy = "ORDER BY $orderBy";
		}else{
			$orderBy = "ORDER BY a.instock_id desc";
		}
		
		$table = "`$this->_table_instock_detail` a 
		          INNER JOIN `$this->_table_instock` b ON a.instock_id=b.instock_id 
		          INNER JOIN `$this->_table_product` p ON p.product_id=a.product_id 
		          INNER JOIN `$this->_table_goods_cat` gc ON gc.cat_id=p.cat_id 
		         ";
		$this -> total = $this -> _db -> fetchOne("SELECT count(*) as count from (SELECT a.instock_id FROM $table $whereSql GROUP BY a.instock_id) a");
		
		return $this -> _db -> fetchAll("SELECT $fields,product_name as goods_name FROM $table $whereSql GROUP BY a.instock_id $orderBy $limit");
	}
	
	/**
     * 获取库存详细数据集
     *
     * @param    string    $where
     * @param    string    $fields
     * @param    string    $orderBy
     * @param    int       $page
     * @param    int       $pageSize
     * @return   array
     */
	public function getPlan($where = null, $fields = '*', $page = null, $pageSize = null, $orderBy = null)
	{
		$pageSize = ((int)$pageSize > 0) ? (int)$pageSize : $this -> _pageSize;
		
		if ($page != null) {
		    $offset = ($page-1)*$pageSize;
		    $limit = "LIMIT $pageSize OFFSET $offset";
		}
		
		if ($where != null) {
			$whereSql = "WHERE $where";
		}
		
		if ($orderBy != null){
			$orderBy = "ORDER BY $orderBy";
		}else{
			$orderBy = "ORDER BY a.instock_id desc";
		}
		
		
		$table = "`$this->_table_instock_plan` a 
		          INNER JOIN `$this->_table_instock` b ON a.instock_id=b.instock_id 
		          INNER JOIN `$this->_table_product` p ON p.product_id=a.product_id 
			      LEFT JOIN `$this->_table_goods_cat` gc ON gc.cat_id=p.cat_id 
			      LEFT JOIN `$this->_table_product_batch` pb ON pb.batch_id=a.batch_id 
		         ";
		$this -> total = $this -> _db -> fetchOne("SELECT count(*) as count FROM $table $whereSql");
		
		return $this -> _db -> fetchAll("SELECT $fields,product_name as goods_name FROM $table $whereSql $orderBy $limit");
	}
	
	/**
     * 获取合计金额
     *
     * @param    string    $where
     * @return   array
     */
	public function getSumAmount($where = null)
	{
	    if ($where != null) {
			$whereSql = "WHERE $where";
		}
		
	    $table = "`$this->_table_instock_plan` a 
		          INNER JOIN `$this->_table_instock` b ON a.instock_id=b.instock_id 
		          INNER JOIN `$this->_table_product` p ON p.product_id=a.product_id 
			      LEFT JOIN `$this->_table_goods_cat` gc ON gc.cat_id=p.cat_id 
			      LEFT JOIN `$this->_table_product_batch` pb ON pb.batch_id=a.batch_id";
		return $this -> _db -> fetchRow("SELECT sum(a.shop_price * if(a.real_number,a.real_number,a.plan_number)) as amount,sum(a.shop_price * if(a.real_number,a.real_number,a.plan_number) / (1 + p.invoice_tax_rate / 100)) as no_tax_amount,sum(a.shop_price * a.real_number) as real_amount,sum(a.shop_price * a.real_number / (1 + p.invoice_tax_rate / 100)) as real_no_tax_amount FROM $table $whereSql");
	}
	
	/**
     * 获取库存详细数据集
     *
     * @param    string    $where
     * @param    string    $fields
     * @param    string    $orderBy
     * @param    int       $page
     * @param    int       $pageSize
     * @return   array
     */
	public function getPlanList($where = null, $fields = '*', $page = null, $pageSize = null, $orderBy = null)
	{
		$pageSize = ((int)$pageSize > 0) ? (int)$pageSize : $this -> _pageSize;
		
		if ($page != null) {
		    $offset = ($page-1)*$pageSize;
		    $limit = "LIMIT $pageSize OFFSET $offset";
		}
		
		if ($where != null) {
			$whereSql = "WHERE $where";
		}
		
		if ($orderBy != null){
			$orderBy = "ORDER BY $orderBy";
		}else{
			$orderBy = "ORDER BY a.instock_id desc";
		}
		
		$table = "`$this->_table_instock_plan` a 
		          INNER JOIN `$this->_table_instock` b ON a.instock_id=b.instock_id 
		          INNER JOIN `$this->_table_product` p ON p.product_id=a.product_id 
			      LEFT JOIN `$this->_table_goods_cat` gc ON gc.cat_id=p.cat_id 
				  LEFT JOIN `$this->_table_supplier` s ON s.supplier_id=b.supplier_id 
		         ";

		$this -> total = $this -> _db -> fetchOne("SELECT count(*) as count from (SELECT a.instock_id FROM $table $whereSql GROUP BY a.instock_id) a");
		
		return $this -> _db -> fetchAll("SELECT $fields,product_name as goods_name,b.add_time as add_time FROM $table $whereSql GROUP BY a.instock_id $orderBy $limit");
	}
	
	/**
     * 获取库存详细数据集
     *
     * @param    string    $where
     * @param    string    $fields
     * @param    string    $orderBy
     * @param    int       $page
     * @param    int       $pageSize
     * @return   array
     */
	public function getDetail($where = null, $fields = '*', $page = null, $pageSize = null, $orderBy = null)
	{
		$pageSize = ((int)$pageSize > 0) ? (int)$pageSize : $this -> _pageSize;
		
		if ($page != null) {
		    $offset = ($page-1)*$pageSize;
		    $limit = "LIMIT $pageSize OFFSET $offset";
		}
		
		if ($where != null) {
			$whereSql = "WHERE $where";
		}
		
		if ($orderBy != null){
			$orderBy = "ORDER BY $orderBy";
		}else{
			$orderBy = "ORDER BY a.instock_id desc";
		}
		
		
		$table = "`$this->_table_instock_detail` a 
		          INNER JOIN `$this->_table_instock` b ON a.instock_id=b.instock_id 
		          INNER JOIN `$this->_table_product` p ON p.product_id=a.product_id 
			      INNER JOIN `$this->_table_goods_cat` gc ON gc.cat_id=p.cat_id 
		         ";
		
		$this -> total = $this -> _db -> fetchOne("SELECT count(*) as count FROM $table $whereSql");
		return $this -> _db -> fetchAll("SELECT $fields,product_name as goods_name,product_sn as goods_sn FROM $table $whereSql $orderBy $limit");
	}
	
	public function getMain($where = 1)
	{
	     return $this -> _db -> fetchAll("select * from {$this->_table_instock} where {$where}");
	}
	
	/**
     * 获取库存详细数据集
     *
     * @param    string    $where
     * @param    string    $fields
     * @param    string    $orderBy
     * @param    int       $page
     * @param    int       $pageSize
     * @return   array
     */
	public function getInDetail($where = null, $fields = '*', $page = null, $pageSize = null, $orderBy = null)
	{
		$pageSize = ((int)$pageSize > 0) ? (int)$pageSize : $this -> _pageSize;
		
		if ($page != null) {
		    $offset = ($page-1)*$pageSize;
		    $limit = "LIMIT $pageSize OFFSET $offset";
		}
		
		if ($where != null) {
			$whereSql = "WHERE $where";
		}
		
		if ($orderBy != null){
			$orderBy = "ORDER BY $orderBy";
		}else{
			$orderBy = "ORDER BY a.instock_id desc";
		}
		
		
		$table = "`$this->_table_instock_detail` a 
		          INNER JOIN `$this->_table_instock` b ON a.instock_id=b.instock_id 
		          INNER JOIN `$this->_table_product` p ON p.product_id=a.product_id 
			      INNER JOIN `$this->_table_goods_cat` gc ON gc.cat_id=p.cat_id 
			      LEFT JOIN  `$this->_table_stock_op` op ON a.instock_id=op.item_id AND item='instock' AND op_type='receive'
		         ";
		
		$this -> total = $this -> _db -> fetchOne("SELECT count(*) as count FROM $table $whereSql");
		
		return $this -> _db -> fetchAll("SELECT $fields,product_name as goods_name FROM $table $whereSql $orderBy $limit");
	}
	
	/**
     * 获取供货商列表
     *
     * @return   array
     */
	public function getSupplier($where = null)
	{
		if ($where != null) {
			$whereSql = "WHERE $where";
		}
		$sql = "SELECT * FROM `$this->_table_supplier` $whereSql ORDER BY CONVERT(supplier_name USING gbk)";

		return $this -> _db -> fetchAll($sql);
	}
	
	/**
     * 添加数据
     *
     * @param    array    $data
     * @return   int      lastInsertId
     */
	public function insert($data)
	{
        $this -> _db -> insert($this -> _table_instock, $data);
		$lastInsertId = $this -> _db -> lastInsertId();
		return $lastInsertId;
	}
	
	/**
     * 添加详细数据
     *
     * @param    array    $data
     * @return   int      lastInsertId
     */
	public function insertPlan($data)
	{
        $this -> _db -> insert($this -> _table_instock_plan, $data);
	}
	
	/**
     * 添加详细数据
     *
     * @param    array    $data
     * @return   int      lastInsertId
     */
	public function insertDetail($data)
	{  
        $this -> _db -> insert($this -> _table_instock_detail, $data);
	}
	
	/**
     * 更新数据
     *
     * @param    array    $data
     * @param    string   $where
     * @return   void
     */
	public function update($data, $where, $type = null)
	{
	    if ($type == null) {
	       $value =  $this -> _db -> update($this -> _table_instock, $data, $where);
	    }else{
	    	$this -> _db -> update($this -> _table_instock_plan, $data, $where);
	    }
	    return true;
	}
	/**
	 * 更新入库详情数据
	 *
	 * @param    array    $data
	 * @param    string   $where
	 * @return   void
	 */
	public function updatedetail($data, $where)
	{
	    $value =  $this -> _db -> update($this -> _table_instock_detail, $data, $where);	    
	    return true;
	}
	
	/**
	 * 更新入库详情数据
	 *
	 * @param    array    $data
	 * @param    string   $where
	 * @return   void
	 */
	public function updatePlan($data, $where)
	{
	    $value =  $this -> _db -> update($this -> _table_instock_plan, $data, $where);	    
	    return true;
	}
	
	/**
     * 添加采购付款数据
     *
     * @param    array    $data
     * @return   int      lastInsertId
     */
	public function insertPayment($data)
	{
        $this -> _db -> insert($this -> _table_purchase_payment, $data);
	}
	
	/**
     * 更新采购付款数据
     *
     * @param    array    $data
     * @return   int      lastInsertId
     */
	public function updatePayment($where, $data)
	{
        $this -> _db -> update($this -> _table_purchase_payment, $data, $where);
	}
	
	/**
     * 删除入库单
     *
     * @return   void
     */
	public function delete($bill_no, $instock_id = null)
	{
	    if (!$instock_id) {
	        $instock_id = $this -> _db -> fetchOne("select instock_id from {$this -> _table_instock} where bill_no = '{$bill_no}'");
	        if (!$instock_id)   return false;
	    }
	    
	    $this -> _db -> delete($this -> _table_instock, "instock_id = {$instock_id}");
	    $this -> _db -> delete($this -> _table_instock_plan, "instock_id = {$instock_id}");
	    $this -> _db -> delete($this -> _table_instock_detail, "instock_id = {$instock_id}");
	}

	/**
	 * 根据条件获取明细数据
	 *
	 * @param    array
	 *
	 * @return   array
	 */
	public function getSaleReportDetailInfosByCondition($params)
	{
		$_condition = array();
		!empty($params['start_ts'])     && $_condition[] = "finish_time >= '{$params['start_ts']}'";
		!empty($params['end_ts'])       && $_condition[] = "finish_time <= '{$params['end_ts']}'";
		!empty($params['bill_type'])    && $_condition[] = "bill_type = '{$params['bill_type']}'";
		!empty($params['bill_status'])  && $_condition[] = "bill_status = '{$params['bill_status']}'";
		isset($params['is_cancel'])     && $_condition[] = "is_cancel = '{$params['is_cancel']}'";
		!empty($params['product_sn'])   && $_condition[] = "product_sn = '{$params['product_sn']}'";
		!empty($params['product_name']) && $_condition[] = "product_name like '%{$params['product_name']}%'";
		!empty($params['supplier_id'])  && $_condition[] = "s.supplier_id = '{$params['supplier_id']}'";

		if (count($_condition) < 1) {
			$this->_error = '没有相关条件';
			return false;
		}

		$_condition[] = "d.product_id > 0";
		//$_condition[] = "sp.is_deleted = 0";

		$sql = "SELECT `finish_time`, GROUP_CONCAT(d.id) AS detail_id,d.`product_id`, GROUP_CONCAT(number) AS numbers, `product_sn`, `product_name`, GROUP_CONCAT(distinct(s.`supplier_id`)) AS supplier_id FROM `shop_instock` i 
				LEFT JOIN `shop_instock_detail` d ON i.instock_id = d.instock_id
				LEFT JOIN `shop_product` p ON d.product_id = p.product_id
				LEFT JOIN `shop_supplier_product` sp ON d.product_id = sp.product_id
				LEFT JOIN `shop_supplier` s ON sp.supplier_id = s.supplier_id
				WHERE ".implode(' AND ', $_condition). " GROUP BY d.product_id";

		$infos = $this->_db->fetchAll($sql);

		if (empty($infos)) {
			return array();
		}

		$ids = array();
		foreach ($infos as $key => $info) {
			$detail_ids = explode(',', $info['detail_id']);
			$numbers    = explode(',', $info['numbers']);
			$number     = 0;
			foreach ($detail_ids as $ke => $detail) {
				if (!isset($ids[$detail])) {
					$ids[$detail] = $detail;
					$number += $numbers[$ke];
				}
			}

			$infos[$key]['number'] = $number;
		}

		return $infos;
	}
	
	/**
     * 根据产品id获取商品出库价
	 *
     * @return   float
     */
	public function getCostByPid($prodid){ 
	    $sql = "SELECT cost FROM shop_product WHERE product_id= ".$prodid;
	    $row = $this -> _db ->fetchRow($sql);
	    return $row['cost'];
	}

	/**
     * 返回错误
	 *
     * @return   string
     */
	public function getError()
	{
		return $this->_error;
	}
}