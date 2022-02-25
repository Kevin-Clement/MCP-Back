<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Step;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Recipe;
use App\Entity\Season;
use App\Entity\Category;
use App\Entity\Material;
use App\Entity\Quantity;
use App\Entity\Supplier;
use App\Entity\Ingredient;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordHasherInterface
     */
    private $encoder;
    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');

        // USER
        for ($u = 0; $u < 5; $u++) {
            $user = new User;
            $hash = $this->encoder->hashPassword($user, "password");

            $user->setEmail($faker->unique()->safeEmail())
                ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setPassword($hash)
                ->setIsArchive($faker->boolean(80));

            if ($u === 0) {
                $user->setRoles(["ROLE_ADMIN"]);
            }

            $manager->persist($user);
        }
        $manager->flush();

        // INGREDIENT
        for ($i = 0; $i < 20; $i++) {
            $ingredient = new Ingredient;
            $ingredient->setINGName($faker->word())
                ->setINGAllergen($faker->boolean(20))
                ->setINGVege($faker->boolean(30))
                ->setINGPrice($faker->numberBetween(0, 20))
                ->setINGIsArchive($faker->boolean(80))
                ->setINGUnit('kg')
                ->setINGDateEdit(new \DateTimeImmutable());

            $manager->persist($ingredient);
        }
        $manager->flush();

        // SEASON
        for ($i = 0; $i < 20; $i++) {
            $season = new Season;
            $season->setSEAName($faker->word())
                ->setSEADateStart(new \DateTime('2020-06-22'))
                ->setSEADateEnd(new \DateTime('2020-08-25'))
                ->setSEAIsArchive($faker->boolean(80))
                ->setSEADateEdit(new \DateTimeImmutable());

            $manager->persist($season);
        }
        $manager->flush();

        // IMAGE
        for ($img = 0; $img < 20; $img++) {
            $image = new Image;
            $image->setIMGName($faker->colorName())
                ->setIMGUri($faker->imageUrl())
                ->setIMGDateEdit(new \DateTime());

            $manager->persist($image);
        }
        $manager->flush();

        // SUPPLIER
        for ($i = 0; $i < 15; $i++) {
            $supplier = new Supplier;
            $supplier->setSUPName($faker->word())
                ->setSUPAddress($faker->streetAddress())
                ->setSUPPostalCode($faker->postcode())
                ->setSUPCity($faker->City())
                ->setSUPPhone('0654545859')
                ->setSUPMail($faker->email())
                ->setSUPIsArchive($faker->boolean(80))
                ->setSUPDateEdit(new \DateTimeImmutable());

            $manager->persist($supplier);
        }
        $manager->flush();

        // CATEGORY
        for ($i = 0; $i < 5; $i++) {
            $category = new Category;
            $category->setName($faker->colorName)
                ->setIsArchive(false);

            $manager->persist($category);
        }
        $manager->flush();

        // RECIPE
        for ($i = 0; $i < 16; $i++) {
            $recipe = new Recipe;
            $recipe->setName($faker->words(3, true))
                ->setComment($faker->text())
                ->setDuration($faker->dateTime())
                ->setPortion($faker->randomDigit())
                ->setInternal($faker->boolean(50))
                ->setMoment($faker->boolean(50))
                ->setSellPrice($faker->randomDigit())
                ->setUsable($faker->boolean(50))
                ->setIsTechnic($faker->boolean(50))
                ->setIsArchive($faker->boolean(50))
                ->setDateEdit(new \DateTimeImmutable());

            $manager->persist($recipe);
        }
        $manager->flush();

        // QUANTITY (LINK_RECIPE_INGREDIENT)
        for ($i = 0; $i < 10; $i++) {
            $quantity = new Quantity;
            $quantity->setQuantity($faker->numberBetween(1, 5));

            $manager->persist($quantity);
        }
        $manager->flush();

        // MATERIAL
        for ($i = 0; $i < 15; $i++) {
            $material = new Material;
            $material->setMATName($faker->word())
                ->setMATIsArchive($faker->boolean(80));

            $manager->persist($material);
        }
        $manager->flush();

        // STEP
        for ($i = 0; $i < 40; $i++) {
            $step = new Step;
            $step->setSTEOrder($faker->numberBetween(1, 5))
                ->setSTEDescription($faker->text(100))
                ->setSTEDateEdit(new \DateTimeImmutable());

            $manager->persist($step);
        }
        $manager->flush();
    }
}
