<?php

namespace sunaw\composer;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;
use Composer\Repository\InstalledRepositoryInterface;

class SunawFramework extends LibraryInstaller
{
    /**
     * {@inheritDoc}
     */
    public function getInstallPath(PackageInterface $package)
    {
        if ('sunaw/framework' !== $package->getPrettyName()) {
            throw new \InvalidArgumentException('Unable to install this library!');
        }


        if ($this->composer->getPackage()) {
            $extra = $this->composer->getPackage()->getExtra();
            if (!empty($extra['sunaw-path'])) {
                return $extra['sunaw-path'];
            }
        }

        return 'sunaw';
    }

    public function install(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        parent::install($repo, $package);
        //remove tests dir
        $this->filesystem->removeDirectory($this->getInstallPath($package) . DIRECTORY_SEPARATOR . 'tests');
    }

    public function update(InstalledRepositoryInterface $repo, PackageInterface $initial, PackageInterface $target)
    {
        parent::update($repo, $initial, $target);
        //remove tests dir
        $this->filesystem->removeDirectory($this->getInstallPath($target) . DIRECTORY_SEPARATOR . 'tests');
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return 'sunaw-framework' === $packageType;
    }
}