<?php

namespace bratiask\OwnAssets\Extension;

use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\Core\Config\Config;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\DataObject;
use SilverStripe\Versioned\Versioned;

class OwnAssetsExtension extends DataExtension
{
    const OWNS = 'owns';

    /**
     * @throws Exception
     */
    public function onAfterWrite()
    {
        if (!$this->isVersioned())
        {
            foreach ($this->ownedComponents() as $componentName => $componentClass)
            {
                if ($this->isAssetClass($componentClass))
                {
                    /** @var Versioned|DataObject $component */
                    $component = $this->owner->getComponent($componentName);

                    if ($component->isInDB() && !$component->isPublished())
                    {
                        $component->publishSingle();
                    }
                }
            }
        }
    }

    /**
     * @return bool
     */
    private function isVersioned()
    {
        return $this->owner->hasExtension('Versioned');
    }

    /**
     * @param string $class
     * @return bool
     */
    private function isAssetClass($class)
    {
        return $class === Image::class || $class === File::class;
    }

    /**
     * @return mixed
     */
    private function ownedComponents()
    {
        return Config::inst()->get($this->owner->getClassName(), self::OWNS);
    }
}