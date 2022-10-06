<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $encodeur;

    public function __construct(UserPasswordHasherInterface $encodeur)
    {

        $this->encodeur = $encodeur;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $nombreVilles = 20;
        $nombreSorties = 30;
        $nombreLieux = $nombreVilles * 3;
        $nombreCampus = 5;
        $nombreParticipants = $faker->numberBetween(20, 100);
        $etats = [];
        $lieux = [];
        $villes = [];
        $campusS = [];
        $participants = [];
        $sorties = [];

        for ($i = 0; $i < $nombreVilles; $i++) {

            $ville = new Ville();
            $ville
                ->setNom($faker->unique()->city())
                ->setCodePostal($faker->numberBetween(00000, 99999));

            $manager->persist($ville);
            $villes[$i] = $ville;
        }

        for ($i = 0; $i < $nombreLieux; $i++) {

            $lieu = new Lieu();
            $lieu
                ->setNom($faker->unique()->streetName)
                ->setLongitude(strval($faker->randomFloat(3, 0, 99.999)))
                ->setLatitude(strval($faker->randomFloat(3, 0, 99.999)))
                ->setRue($faker->unique()->streetAddress())
                ->setVille($faker->randomElement($villes));


            $manager->persist($lieu);
            $lieux[$i] = $lieu;
        }

        for ($i = 0; $i < $nombreCampus; $i++) {

            $campus = new Campus();
            $campus
                ->setNom($faker->unique()->citySuffix());

            $manager->persist($campus);
            $campusS[$i] = $campus;
        }

        for ($i = 0; $i < 4; $i++) {

            $etat = new Etat();
            $NICKTOUT = ["créée", "ouverte", "cloturée", "fermé"];

            $etat->setLibelle($NICKTOUT[$i]);

            $manager->persist($etat);
            $etats[$i] = $etat;
        }

        for ($i = 0; $i < $nombreParticipants; $i++) {

            $participant = new Participant();
            $participant
                ->setNom($faker->unique()->lastName())
                ->setPrenom($faker->unique()->firstName())
                ->setPseudo($faker->unique()->word())
                ->setTelephone("0666666666")
                ->setEmail($faker->unique()->email())
                ->setAdministrateur($faker->boolean)
                ->setMotPasse($this->encodeur->hashPassword($participant, "1234"))
                ->setCampus($faker->randomElement($campusS));

            $manager->persist($participant);
            $participants[$i] = $participant;
        }

        for ($i = 0; $i < $nombreSorties; $i++) {

            $nombreParticipantsMax = ($faker->numberBetween(0, 100));
            $nombreParticipants = ($faker->numberBetween(0, $nombreParticipantsMax));

            $sortie = new Sortie();
            $sortie
                ->setNom($faker->unique()->sentence(4))
                ->setDateHeureDebut($faker->dateTimeBetween('+2 months', "+2 years"))
                ->setDuree($faker->numberBetween(0, 100))
                ->setDateLimiteInscription($faker->dateTimeBetween('now', "+2 months"))
                ->setInfosSortie($faker->unique()->text(1000))
                ->setNbInscriptionsMax($nombreParticipantsMax)
                ->setCampus($faker->randomElement($campusS))
                ->setOrganisateur($faker->randomElement($participants))
                ->setEtat($faker->randomElement($etats))
                ->setLieu($faker->randomElement($lieux));

            for ($j = 0; $j < $nombreParticipants; $j++) {

                $sortie->addParticipant($faker->randomElement($participants));
            }

            $manager->persist($sortie);
            $sorties[$i] = $sortie;
        }

        $manager->flush();
    }
}
