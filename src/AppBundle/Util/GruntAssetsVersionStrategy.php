<?php
namespace AppBundle\Util;

use Symfony\Component\Asset\VersionStrategy\VersionStrategyInterface;

/**
 * VersionStrategy for consume the mapping file generate from grunt plugin grunt-assets-versioning
 *
 * @package AppBundle\Util
 */
class GruntAssetsVersionStrategy implements VersionStrategyInterface
{
    /**
     * @var array
     */
    private $mapping;

    /**
     * @param $mappingFilePath
     */
    public function __construct($mappingFilePath)
    {
        $this->mapping = [];

        if (!empty($mappingFilePath) && is_readable($mappingFilePath)) {
            $this->mapping = $this->createMappingArrayFromFile($mappingFilePath);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getVersion($path)
    {
        if (isset($this->mapping[$path])) {
            return $this->mapping[$path]['version'];
        }

        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function applyVersion($path)
    {
        if (isset($this->mapping[$path])) {
            return $this->mapping[$path]['versionedPath'];
        }

        return $path;
    }

    /**
     * @TODO: cache the parsed file?
     *
     * @param string $mappingFilePath
     *
     * @return array
     */
    private function createMappingArrayFromFile(string $mappingFilePath): array
    {
        $mapping = [];
        $jsonArray = json_decode(file_get_contents($mappingFilePath), true);

        if (is_array($jsonArray)) {
            foreach ($jsonArray as $asset) {
                $mapping[ $asset['originalPath'] ] = [
                    'version' => $asset['version'],
                    'versionedPath' => $asset['versionedPath']
                ];
            }
        }

        return $mapping;
    }
}