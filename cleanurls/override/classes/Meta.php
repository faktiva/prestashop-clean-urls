<?php
class Meta extends MetaCore
{
	/**
	 * Get CMS meta tags
	 *
	 * @since 1.5.0
	 * @param int $id_cms
	 * @param int $id_lang
	 * @param string $page_name
	 * @return array
	 */
	public static function getCmsMetas($id_cms, $id_lang, $page_name)
	{
		$multishop = (int)Context::getContext()->shop->id ? ' AND id_shop = '.(int)Context::getContext()->shop->id : '';
		
		$sql = 'SELECT `meta_title`, `meta_description`, `meta_keywords`
				FROM `'._DB_PREFIX_.'cms_lang`
				WHERE id_lang = '.(int)$id_lang.'
					AND id_cms = '.(int)$id_cms.
					$multishop;
		if ($row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($sql))
		{
			$row['meta_title'] = $row['meta_title'].' - '.Configuration::get('PS_SHOP_NAME');
			return Meta::completeMetaTags($row, $row['meta_title']);
		}

		return Meta::getHomeMetas($id_lang, $page_name);
	}

	/**
	 * Get CMS category meta tags
	 *
	 * @since 1.5.0
	 * @param int $id_cms_category
	 * @param int $id_lang
	 * @param string $page_name
	 * @return array
	 */
	public static function getCmsCategoryMetas($id_cms_category, $id_lang, $page_name)
	{
		$multishop = (int)Context::getContext()->shop->id ? ' AND id_shop = '.(int)Context::getContext()->shop->id : '';
		
		$sql = 'SELECT `meta_title`, `meta_description`, `meta_keywords`
				FROM `'._DB_PREFIX_.'cms_category_lang`
				WHERE id_lang = '.(int)$id_lang.'
					AND id_cms_category = '.(int)$id_cms_category.
					$multishop;
		if ($row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($sql))
		{
			$row['meta_title'] = $row['meta_title'].' - '.Configuration::get('PS_SHOP_NAME');
			return Meta::completeMetaTags($row, $row['meta_title']);
		}

		return Meta::getHomeMetas($id_lang, $page_name);
	}
}
