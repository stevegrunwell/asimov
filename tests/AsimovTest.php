<?php
/**
 * Tests for the main Asimov script.
 *
 * @package Asimov
 */

namespace Tests;

class AsimovTest extends TestCase
{
    /**
     * A test case that catches the easiest pattern: a dependency file exists in the project
     * directory, and its dependencies are installed into an adjacent directory.
     *
     * When adding a simple pattern, please add it as a scenario for this test.
     *
     * @test
     * @testWith ["Bower", "bower.json", "bower_components"]
     *           ["Composer", "composer.json", "vendor"]
     *           ["Node", "package.json", "node_modules"]
     *           ["Vagrant", "Vagrantfile", ".vagrant"]
     */
    public function it_should_exclude_dependency_directories_when_a_config_file_is_present($system, $config, $dependencies)
    {
        $this->createDirectoryStructure([
            'Code' => [
                "My-$system-Project" => [
                    $dependencies => [],
                    $config       => 'Configuration for this platform.',
                ],
            ],
        ]);

        $this->assertEquals(
            [$this->getFilepath("Code/My-$system-Project/$dependencies")],
            $this->asimov(),
            "When a $config file is present, $dependencies/ should be excluded."
        );
    }

    /**
     * A run should pick up multiple dependencies, not just the first.
     *
     * @test
     */
    public function it_should_find_multiple_matches()
    {
        $this->createDirectoryStructure([
            'Code' => [
                'First-Project' => [
                    'vendor'        => [],
                    'composer.json' => 'Configuration for this platform.',
                ],
                'Second-Project' => [
                    'vendor'        => [],
                    'composer.json' => 'Configuration for this platform.',
                ],
            ],
        ]);

        $this->assertEquals(
            [
                $this->getFilepath('Code/First-Project/vendor'),
                $this->getFilepath('Code/Second-Project/vendor'),
            ],
            $this->asimov(),
            'All matches should be excluded in a single pass.'
        );
    }
}
