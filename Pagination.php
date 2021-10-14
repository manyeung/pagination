<?php

class Pagination
{
	protected $perPage;
	// start from 0
	protected $current;
	protected $count;
	protected $maxPage;

	public function init($count, $perPage, $current)
	{
		$this->perPage = $perPage;
		$this->count = $count;
		$this->current = $current;

		$this->findMaxPage();
		$this->findCurrent();
	}

	protected function findMaxPage()
	{
		$this->maxPage = (int) floor($this->count / $this->perPage);
	}

	protected function findCurrent()
	{
		$index = $this->current;

		$current = $index < 0
			? 0
			: ($index < $this->maxPage ? $index : $this->maxPage);

		$this->current = (int) $current;
	}

	public function getOffset()
	{
		$offset = $this->current * $this->perPage;
		return $offset;
	}

	public function getPagers()
	{
		$pagers = array($this->current);

		while (count($pagers) < min(9, $this->maxPage + 1)) {
			$first = $pagers[0];
			$last = $pagers[count($pagers) - 1];
			$prev = $first - 1;
			$next = $last + 1;
			if ($prev >= 0) {
				array_unshift($pagers, $prev);
			}
			if ($next <= $this->maxPage) {
				array_push($pagers, $next);
			}
		}

		return $pagers;
	}

	public function toArray()
	{
		return array(
			'count' => $this->count,
			'per_page' => $this->perPage,
			'max_page' => $this->maxPage,
			'current' => $this->current,
			'offset' => $this->getOffset(),
			'pagers' => $this->getPagers(),
		);
	}
}
