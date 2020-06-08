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
     * Data provider for known patterns.
     *
     * @return array[] An array of test scenarios, in the form of "sentinel => directory".
     */
    public function recognizedPatternProvider(): array
    {
        return [
            'Bower'     => ['bower.json', 'bower_components'],
            'Cargo'     => ['Cargo.toml', 'target'],
            'Carthage'  => ['Cartfile', 'Carthage'],
            'CocoaPods' => ['Podfile', 'Pods'],
            'Composer'  => ['composer.json', 'vendor'],
            'Maven'     => ['pom.xml', 'target'],
            'Node'      => ['package.json', 'node_modules'],
            'Stack'     => ['stack.yaml', '.stack-work'],
            'Swift'     => ['Package.swift', '.build'],
            'Vagrant'   => ['Vagrantfile', '.vagrant'],
        ];
    }

    /**
     * A test case that catches the easiest pattern: a dependency file exists in the project
     * directory, and its dependencies are installed into an adjacent directory.
     *
     * When adding a simple pattern, please add it as a scenario for this test.
     *
     * @test
     * @dataProvider recognizedPatternProvider()
     */
    public function it_should_exclude_dependency_directories_when_a_config_file_is_present($config, $dependencies)
    {
        $this->createDirectoryStructure([
            'Code' => [
                "My-Project" => [
                    $dependencies => [],
                    $config       => 'Configuration for this platform.',
                ],
            ],
        ]);

        $this->assertEquals(
            [$this->getFilepath("Code/My-Project/$dependencies")],
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

    /**
     * Once a dependency has been excluded, there's no need to exclude it again.
     *
     * @test
     */
    public function it_should_only_exclude_new_matches()
    {
        $this->createDirectoryStructure([
            'Code' => [
                'My-Project' => [
                    'vendor'        => [],
                    'composer.json' => 'Configuration for this platform.',
                ],
            ],
        ]);

        $this->assertNotEmpty(
            $this->asimov(),
            'Asimov should have found one path on its first run.'
        );

        $this->assertEmpty(
            $this->asimov(),
            'Asimov should not have found any new paths on the second run.'
        );
    }
}
