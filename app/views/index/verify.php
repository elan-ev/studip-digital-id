<?php

/**
 * verify.php - Stud.IP plugin for digital campus card
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Student ID - Google Wallet</title>
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .wallet-card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 350px;
        }
        .card-header {
            background-color: #4285f4;
            color: white;
            padding: 16px;
            font-size: 18px;
            font-weight: 500;
        }
        .card-content {
            padding: 16px;
        }
        .student-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 16px;
        }
        .student-name {
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 16px;
        }
        .student-photo {
            width: 100%;
            height: auto;
            border-radius: 8px;
            object-fit: cover;
        }
        .info-row {
            display: flex;
            flex-direction: column;
            margin-bottom: 16px;
        }
        .info-label {
            color: #5f6368;
            font-size: 14px;
            margin-bottom: 4px;
        }
        .info-value {
            font-size: 18px;
            font-weight: 500;
        }
        .qr-code {
            text-align: center;
            margin-top: 16px;
        }
        .qr-code img {
            width: 150px;
            height: 150px;
        }
    </style>
</head>
<body>
    <div class="wallet-card">
        <div class="card-header">
            Studierendenausweis <?= $digicard_user->getInstitution() ?>
        </div>
        <div class="card-content">
            <div class="student-info">
                <div class="student-name"><?= $digicard_user->getName() ?></div>
                <img src="<?= $controller->url_for('index/student_photo', $token) ?>" alt="Student Photo" class="student-photo">
            </div>
            <div class="info-row">
                <span class="info-label">Matrikelnummer</span>
                <span class="info-value"><?= $digicard_user->getMatrikel() ?></span>
            </div>

            <? foreach ($digicard_user->getStudycourses() as $course) : ?>
            <div class="info-row">
                <span class="info-label"><?= $course['name'] ?></span>
                <span class="info-value">Fachsemester: <?= $course['semester'] ?></span>
            </div>
            <? endforeach ?>

            <div class="info-row">
                <span class="info-label">Semesterzeitraum / Gültigkeit</span>
                <span class="info-value"><?= $digicard_user->getSemesterStart() ?> - <?= $digicard_user->getSemesterEnd() ?></span>
            </div>
        </div>
    </div>
</body>
</html>