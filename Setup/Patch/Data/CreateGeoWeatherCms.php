<?php
declare(strict_types=1);

namespace Test\GeoWeather\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Cms\Model\BlockFactory;

/**
 * Create CMS block with geoweather data
 */
class CreateGeoWeatherCms implements DataPatchInterface, PatchRevertableInterface
{
    const BLOCK_IDENTIFIER = 'geoWeather-cms-block';
    /**
     * @var BlockFactory
     */
    protected $blockFactory;

    /**
     * UpdateBlockData constructor.
     * @param BlockFactory $blockFactory
     */
    public function __construct(
        BlockFactory $blockFactory
    ) {
        $this->blockFactory = $blockFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $blockData = [
            'title' => 'Test GeoWeather CMS block',
            'identifier' => self::BLOCK_IDENTIFIER,
            'content' => $this->getBlockContent(),
            'stores' => [0],
            'is_active' => 1,
        ];
        $headerNoticeBlock = $this->blockFactory
            ->create()
            ->load($blockData['identifier'], 'identifier');

        /**
         * Create the block if it does not exists, otherwise update the content
         */
        if (!$headerNoticeBlock->getId()) {
            $headerNoticeBlock->setData($blockData)->save();
        } else {
            $headerNoticeBlock->setContent($blockData['content'])->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        /**
         * No dependencies for this
         */
        return [];
    }

    /**
     * Delete the block
     */
    public function revert()
    {
        $headerNoticeBlock = $this->blockFactory
            ->create()
            ->load(self::BLOCK_IDENTIFIER, 'identifier');

        if($headerNoticeBlock->getId()) {
            $headerNoticeBlock->delete();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        /**
         * Aliases are useful if we change the name of the patch until then we do not need any
         */
        return [];
    }

    /**
     * Get html content of our block
     *
     * @return string
     */
    private function getBlockContent(): string
    {
        return " <div id=\"geoWeather\" class=\"customer-welcome\" >
    <div
        class=\"action online-select\"
        data-action=\"customer-menu-toggle\"
        data-bind=\"scope: 'example-scope'\"
    >
            <div>
                <span data-bind=\"text: geoWeather().position\" ></span>
            </div>
           <div>
                <span>Temperature: </span>
                <span data-bind=\"text: geoWeather().temperature\" ></span>
                <span>&deg;</span>
            </div>
            <div>
                <span>Wind speed: </span>
                <span data-bind=\"text: geoWeather().windSpeed\" ></span>
                <span> kph</span>
            </div>
            <div>
                <span>Wind direction: </span>
                <span data-bind=\"text: geoWeather().windDirection\" ></span>
                <span>&deg;</span>
            </div>
            <div>
                <span>Relative humidity: </span>
                <span data-bind=\"text: geoWeather().humidity\" ></span>
                <span> %</span>
            </div>
    </div>
    </div>
    <script type=\"text/x-magento-init\">
        {
             \"*\": {
                      \"Magento_Ui/js/core/app\": {
                           \"components\": {
                               \"example-scope\": {
                                  \"component\": \"Test_GeoWeather/js/geoweather\"
                                }
                          }
                     }
              }
            }
        </script>
    ";
    }
}
