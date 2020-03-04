<?php

if ($arParams['SHOW_MAX_QUANTITY'] !== 'N')
{
	if ($haveOffers)
	{
		?>
		<div class="product-item-detail-info-container" id="<?=$itemIds['QUANTITY_LIMIT']?>" style="display: none;">
			<div class="product-item-detail-info-container-title">
				<?=$arParams['MESS_SHOW_MAX_QUANTITY']?>:
				<span class="product-item-quantity" data-entity="quantity-limit-value"></span>
			</div>
		</div>
		<?
	}
	else
	{
		if (
			$measureRatio
			&& (float)$actualItem['PRODUCT']['QUANTITY'] > 0
			&& $actualItem['CHECK_QUANTITY']
		)
		{
			?>
			<div class="product-item-detail-info-container" id="<?=$itemIds['QUANTITY_LIMIT']?>">
				<div class="product-item-detail-info-container-title">
					<?=$arParams['MESS_SHOW_MAX_QUANTITY']?>:
					<span class="product-item-quantity" data-entity="quantity-limit-value">
						<?
						if ($arParams['SHOW_MAX_QUANTITY'] === 'M')
						{
							if ((float)$actualItem['PRODUCT']['QUANTITY'] / $measureRatio >= $arParams['RELATIVE_QUANTITY_FACTOR'])
							{
								echo $arParams['MESS_RELATIVE_QUANTITY_MANY'];
							}
							else
							{
								echo $arParams['MESS_RELATIVE_QUANTITY_FEW'];
							}
						}
						else
						{
							echo $actualItem['PRODUCT']['QUANTITY'].' '.$actualItem['ITEM_MEASURE']['TITLE'];
						}
						?>
					</span>
				</div>
			</div>
			<?
		}
	}
}