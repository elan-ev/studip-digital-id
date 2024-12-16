<?php

/**
 * User.php - Stud.IP plugin for digital campus card
 *
 * This file is part of the digital campus card Stud.IP plugin.
 *
 * @package    DigicardWebApp
 * @author     Till Glöggler <gloeggler@elan-ev.de>
 * @copyright  2025 ELAN e.V.
 * @license    https://www.gnu.org/licenses/agpl-3.0.html AGPL-3.0-or-later
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace DigiCard;

/**
 * Class User
 *
 * This class represents a user (student) with their associated information.
 */
class User
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $matrikel;

    /** @var string */
    private $imageUrl;

    /** @var string */
    private $institution;

    /** @var array */
    private $studycourses;

    /** @var string */
    private $semesterStart;

    /** @var string */
    private $semesterEnd;

    /**
     * User constructor.
     *
     * @param string $id
     * @param string $name
     * @param string $matrikel
     * @param string $imageUrl
     * @param string $institution
     * @param string $studycourses
     * @param string $semesterStart
     * @param string $semesterEnd
     */
    public function __construct(
        string $id,
        string $name,
        string $matrikel,
        string $imageUrl,
        string $institution,
        array $studycourses,
        string $semesterStart,
        string $semesterEnd
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->matrikel = $matrikel;
        $this->imageUrl = $imageUrl;
        $this->institution = $institution;
        $this->studycourses = $studycourses;
        $this->semesterStart = $semesterStart;
        $this->semesterEnd = $semesterEnd;
    }

    public static function getDigicardUser($user, $token)
    {
        $studycourses = [];

        foreach ($user->studycourses as $course) {
            $studycourses[] = [
                'name'     => $course->studycourse->name .', '. $course->degree->name,
                'semester' => $course->semester
            ];
        }

        $semester = \Semester::findCurrent();

        \URLHelper::setBaseUrl($GLOBALS['ABSOLUTE_URI_STUDIP']);

        return new self(
            $user->username,
            $user->getFullName(),
            $user->matriculation_number,
            \PluginEngine::getUrl('digicard/index/student_photo/'. $token),
            $GLOBALS['UNI_NAME_CLEAN'] ?: 'Universität Osnabrück',
            $studycourses,
            date('d.m.Y', $semester->beginn),
            date('d.m.Y', $semester->ende)
        );
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getMatrikel(): string
    {
        return $this->matrikel;
    }

    /**
     * @param string $matrikel
     */
    public function setMatrikel(string $matrikel): void
    {
        $this->matrikel = $matrikel;
    }

    /**
     * @return string
     */
    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    /**
     * @param string $imageUrl
     */
    public function setImageUrl(string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @return string
     */
    public function getInstitution(): string
    {
        return $this->institution;
    }

    /**
     * @param string $institution
     */
    public function setInstitution(string $institution): void
    {
        $this->institution = $institution;
    }

    /**
     * @return array
     */
    public function getStudycourses(): array
    {
        return $this->studycourses;
    }

    /**
     * @param array $studycourses
     */
    public function setStudycourses(array $studycourses): void
    {
        $this->studycourses = $studycourses;
    }



    /**
     * @return string
     */
    public function getSemesterStart(): string
    {
        return $this->semesterStart;
    }

    /**
     * @param string $semesterStart
     */
    public function setSemesterStart(string $semesterStart): void
    {
        $this->semesterStart = $semesterStart;
    }

    /**
     * @return string
     */
    public function getSemesterEnd(): string
    {
        return $this->semesterEnd;
    }

    /**
     * @param string $semesterEnd
     */
    public function setSemesterEnd(string $semesterEnd): void
    {
        $this->semesterEnd = $semesterEnd;
    }

    /**
     * Convert the User object to an array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'matrikel'      => $this->matrikel,
            'imageUrl'      => $this->imageUrl,
            'institution'   => $this->institution,
            'studycourses'  => $this->studycourses,
            'semesterStart' => $this->semesterStart,
            'semesterEnd'   => $this->semesterEnd,
        ];
    }
}