<?php
/**
 * Copyright 2016 Luis Alberto Pabon Flores
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace AppBundle\Controller;

use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Base controller
 *
 * @package AppBundle\Controller
 * @author  Luis A. Pabon Flores
 */
class AbstractController extends Controller
{
    /**
     * Validates any recaptcha response.
     *
     * @param Request $request
     *
     * @return bool
     */
    protected function checkRecaptcha(Request $request)
    {
        // Disable checks on test environment
        if ($this->container->get('kernel')->getEnvironment() === 'test') {
            return true;
        }

        return $this->container
            ->get('recaptcha_validator')
            ->verify($request->get('g-recaptcha-response'));
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->getDoctrine()->getManager();
    }

    /**
     * @param string $databaseTable
     *
     * @return EntityRepository
     */
    protected function getDatabaseTable(string $databaseTable): EntityRepository
    {
        return $this->getEntityManager()->getRepository($databaseTable);
    }
}
