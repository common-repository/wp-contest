<?php 
/*  
* 	@PACKAGE WP CONTEST
*	USE: USE TO DELETE ENTRY
*/

if(!class_exists('WPCPageLister')){
	class WPCPageLister
	{
		protected $allItems = array();
		protected $page = 1;
		protected $pageList = array();

	/**
	 * Default options
	 *
	 * @var array
	 */
	protected $opts = array(
		'itemsPerPage' => 10,
		'urlFormat'		 => '%d',
		'pageLabels'	 => array(),
		'prevAndNext'	 => true,
		'prev'				=> '&laquo;',
		'next'				=> '&raquo;'
	);

	function __construct($allItems, $page, $opts=array())
	{
		$this->setAllItems($allItems);
		$this->setPage($page);
		$this->setOpts(array_merge($this->getOpts(), $opts));
	}

	function makePageList()
	{
		$page = $this->getPage();
		$allItems = $this->getAllItems();
		$urlFormat = $this->getOpt('urlFormat');
		$prevAndNext = $this->getOpt('prevAndNext');
		$pageLabels = $this->getOpt('pageLabels');
		$itemsPerPage = $this->getOpt('itemsPerPage');

		$numPages = ceil(count($allItems)/$itemsPerPage);

		$pageList = array();

		$prev = $page-1;
		$next = $page+1;
		$prevUrl = $prev>0 ? sprintf($urlFormat, $prev) : null;
		$nextUrl = $next<=$numPages ? sprintf($urlFormat, $next) : null;

		if ($prevAndNext)
		{
			$pageList[] = array(
				'pop_page'  => $prev,
				'url'	  => $prevUrl,
				'label' => $this->getOpt('prev')
			);
		}

		for ($i=1; $i<=$numPages; $i++)
		{
			$curUrl = $page!=$i ? sprintf($urlFormat, $i) : null;
			$pageList[] = array(
				'pop_page'  => $i,
				'url'	  => $curUrl,
				'label' => isset($pageLabels[$i]) ? $pageLabels[$i] : $i
			);
		}

		if ($prevAndNext)
		{
			$pageList[] = array(
				'pop_page'  => $next,
				'url'	  => $nextUrl,
				'label' => $this->getOpt('next')
			);
		}

		$this->setPageList($pageList);
		return $pageList;
	}

	/**
	 * Returns current items
	 *
	 * @return array
	 */
	function getCurrentItems()
	{
		$allItems = $this->getAllItems();
		$page = $this->getPage();
		$itemsPerPage = $this->getOpt('itemsPerPage');

		return array_slice($allItems, ($page-1)*$itemsPerPage, $itemsPerPage);
	}

	/**
	 * Returns a single option
	 *
	 * @param string $opt
	 * @return mixed
	 */
	function getOpt($opt)
	{
		$opts = $this->getOpts();
		if (isset($opts[$opt]))
		{
			return $opts[$opt];
		}
		return null;
	}

	function setAllItems($allItems) { $this->allItems = $allItems; }
	function getAllItems() { return $this->allItems; }
	function setPage($page) { $this->page = $page; }
	function getPage() { return $this->page; }
	function setOpts($opts) { $this->opts = $opts; }
	function getOpts() { return $this->opts; }
	function setPageList($pageList) { $this->pageList = $pageList; }
	function getPageList() { return $this->pageList; }
}
}