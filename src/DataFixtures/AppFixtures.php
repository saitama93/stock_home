<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Mark;
use App\Entity\Role;
use App\Entity\Type;
use App\Entity\User;
use App\Entity\Status;
use App\Entity\Location;
use App\Entity\Equipment;
use App\Entity\Specificity;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        // Gestion des utilisateurs
        $faker = Factory::create('fr_FR');
        $users = [];
        $genres = ['male', 'female'];

        // CREATION DES ROLES
        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        $publicRole = new Role();
        $publicRole->setTitle("ROLE_PUBLIC");
        $manager->persist($publicRole);

        $userRole = new Role();
        $userRole->setTitle("ROLE_USER");
        $manager->persist($userRole);

        $allRoles = [];
        $allRoles = $userRole;

        // CREATIONS DES USERS

        $admin = new User();

        $admin->setFirstName("Igal")
        ->setLastName("ILMI AMIR")
        ->setEmail("igal@stock.fr")
        ->setPassword($this->encoder->encodePassword($admin, "password123!"))
        ->setPresent(1)
        ->setUsername("Igal")
        ->addUserRole($adminRole, $userRole);
        $manager->persist($admin);

       
        $public = new User();

        $public->setFirstName("Public")
        ->setLastName("PUBLIC")
        ->setEmail("public@stock.fr")
        ->setPassword($this->encoder->encodePassword($public, "password123!"))
        ->setPresent(1)
        ->setUsername("Publique")
        ->addUserRole($publicRole, $userRole);

        $manager->persist($public);

        $statutes = [
            'SAV',
            'En stock',
            'A réformer',
            'Déployé sur le site'
        ];

        $locations = [
            'amancey.ce',
            'audincourt.annexe-champs',
            'audincourt.ase-pmi',
            'audincourt.ce-eams',
            'audincourt.cms-gare',
            'baume-les-dames.bal-ce',
            'baume-les-dames.cms',
            'besançon.13-15-pref',
            'besançon.18-pref-drmg-ds',
            'besançon.23-nodier-pec',
            'besançon.3bis-lussac',
            'besançon.3-lussac',
            'besançon.8-nodier',
            'besançon.archives-dpt',
            'besançon.cde-bosquet',
            'besançon.cde-chaille',
            'besançon.cdef-torcols',
            'besançon.cdef-wyrsch',
            'besançon.centre-planif',
            'besançon.cmps-pmi-palente',
            'besançon.cms-bacchus',
            'besançon.cms-montrapon',
            'besançon.cms-past-pec-planoise',
            'besançon.cms-st-claude',
            'besançon.cms-st-ferjeux',
            'besançon.cms-tristan-b',
            'besançon.datacenter',
            'besançon.fort-griffon',
            'besançon.hotel',
            'besançon.lvd',
            'besançon.medecine',
            'besançon.mediatheque-dpt',
            'besançon.parc-routier',
            'besançon.sta-clairiere',
            'besançon.uef-fontaine-argent',
            'bethoncourt.cms',
            'chalezeule.ce',
            'clerval.cms',
            'devecey.cms',
            'etupes.cms',
            'exincourt.acc-urg',
            'exincourt.cdef',
            'flagey.ferme',
            'franois.ce',
            'grand-charmont.cms',
            'le-doubs.bal-ce-cms',
            'le-russey.ce-perm',
            'levier.ce',
            'maiche.bal-ce',
            'maiche.cms',
            'mandeure.cms',
            'montbeliard.cms-chiffogne',
            'montbeliard.cms-petit-chenois',
            'montbeliard.maison-dpt',
            'montbeliard.parc-bal-ce-cer',
            'montbeliard.planif-schiffle',
            'montbeliard.quasar-ase',
            'montbeliard.sta',
            'montbeliard.syndic',
            'morteau.ce',
            'morteau.cms',
            'morteau.past',
            'mouthe.ce-perm',
            'novillars.cms',
            'orchamps-vennes.bal-ce',
            'ornans.atelier',
            'ornans.bal-ce',
            'ornans.cms',
            'ornans.musee',
            'pontarlier.bal-egr',
            'pontarlier.cms-magnin',
            'pontarlier.cms-planif',
            'pontarlier.maison-dpt-phd',
            'pontarlier.parc-sta-ce',
            'pontarlier.phd',
            'pont-de-roide.ce',
            'pont-de-roide.cms',
            'quingey.ce',
            'quingey.cms',
            'rougemont.cms-ce',
            'saint-hippolyte.ce',
            'saint-vit.cms',
            'sancey-le-grand.ce',
            'saone.ce',
            'saone.cms',
            'seloncourt.cms',
            'serre-les-sapins.cms',
            'valdahon.ce',
            'valdahon.cms',
            'valentigney.buis',
            'valentigney.cms-zac'
        ];

        $specificities = [
            'i3',
            'i5',
            'i7',
            'HD',
            '4K'
        ];

        $brands = [
            'HP',
            'Canon',
            'Ricoh',
            'Sony',
            'NetGear',
            'D-Link',
            'TP-Link'
        ];

        $types =  [
            'Ordinateur',
            'Imprimante',
            'Switch',
            'Rooter',
            'Cable'
        ];



        for ($z = 1; $z <= 50; $z++) {
            $user = new User();
            $genre = $faker->randomElement($genres);
            $hash = $this->encoder->encodePassword($user, 'password123!');

            $user->setFirstName($faker->firstName($genre))
                ->setLastName($faker->lastName)
                ->setEmail($faker->email)
                ->setUsername($faker->userName)
                ->setPresent(rand(0, 1))
                ->setPassword($hash)
                ->addUserRole($userRole);

            $manager->persist($user);
            $users[] = $user;
        }


        for ($i = 0; $i <= 3; $i++) {

            $status = new Status();
            $wording = $statutes[$i];
            $status->setWording($wording);

            $manager->persist($status);
        }

        for ($j = 0; $j <= 89; $j++) {
            $location = new Location();
            $wording = $locations[$j];
            $location->setWording($wording);

            $manager->persist($location);
        }

        for ($l = 0; $l <= 4; $l++) {
            $specificity = new Specificity();
            $wording = $specificities[$l];
            $specificity->setWording($wording);

            $manager->persist($specificity);
        }

        for ($m = 0; $m <= 6; $m++) {
            $mark = new Mark();
            $wording = $brands[$m];
            $mark->setWording($wording);

            $manager->persist($mark);
        }

        for ($t = 0; $t <= 4; $t++) {
            $type = new Type();
            $wording = $types[$t];
            $type->setWording($wording);

            $manager->persist($type);
        }

        $manager->flush();
    }
}
