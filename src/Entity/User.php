<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields="email", errorPath="/login",message="Un autre utilisateur s'est déjà inscrit avec cette adresse email, merci de la modifier")
 * @Vich\Uploadable()
 */
class User implements UserInterface //,  \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max=50)
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Votre nom ne peut contenir de nombre."
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max=50)
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Votre prénom ne peut contenir de nombre."
     * )
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Email(
     * message="Votre mail n'est pas valide"
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max=60)
     * @Assert\Regex(
     * * pattern = "/^(?=.*\d)(?=.*[A-Z])(?=.*[@#$%])(?!.*(.)\1{2}).*[a-z]/m",
     * match=true,
     * message="Votre mot de passe doit comporter au moins huit caractères, dont des lettres majuscules et minuscules, un chiffre et un symbole (@-#-$-%).")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phoneNumber;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @ORM\Column(name="roles", type="array")
     */
    private $roles = array();

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @Assert\File(mimeTypes={ "image/png", "image/jpeg" }),
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @Vich\UploadableField(mapping="avatar_image", fileNameProperty="avatar")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatarFile;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commande", mappedBy="user")
     */
    private $commandes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="user_proprio")
     */
    private $user_proprio;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="user_acheteur")
     */
    private $user_acheteur;

    


    

    public function __construct() {
        $this->isActive = true;
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid('', true));

        $this->commandes = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->products_proprio = new ArrayCollection();
        $this->products_ache = new ArrayCollection();
        $this->user_proprio = new ArrayCollection();
        $this->user_acheteur = new ArrayCollection();    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getphoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setphoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    function getIsActive() {
        return $this->isActive;
    }

    function setIsActive($isActive) {
        $this->isActive = $isActive;
    }

    public function getUsername() {
        return $this->email;
    }

    public function getSalt() {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getRoles() {
        if (empty($this->roles)) {
            return ['ROLE_USER'];
        }
        return $this->roles;
    }

    function addRole($role) {
        $this->roles[] = $role;
    }

    public function eraseCredentials() {
       
    }

    /**
     * @return null|string
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     *
     * @param File|UploadedFile $image
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
        return $this->avatar;
    }

    public function setAvatarFile(? File $avatar = null) : void
    {
        $this->avatarFile = $avatar;

        if (null !== $avatar) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }


    public function getAvatarFile() : ? File
    {
        return $this->avatarFile;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setUser($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->contains($commande)) {
            $this->commandes->removeElement($commande);
            // set the owning side to null (unless already changed)
            if ($commande->getUser() === $this) {
                $commande->setUser(null);
            }
        }

        return $this;
    }


    /*public function serialize()
    {
        return serialize(array(
            $this->id,
            //$this->userName,
            $this->password,
            $this->avatar,
            // see section on salt below
            // $this->salt,
        ));
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            //$this->userName,
            $this->password,
            $this->avatar,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized, array('allowed_classes' => false));
    }*/

    /**
     * @return Collection|Product[]
     */
    public function getProductsProprio(): Collection
    {
        return $this->user_proprio; //productsProprio
    }

    public function addProductsProprio(Product $user_proprio): self
    {
        if (!$this->user_proprio->contains($user_proprio)) { //productsProprio
            $this->user_proprio[] = $user_proprio;
            $user_proprio->setUserIdProprio($this);
        }

        return $this;
    }

    public function removeProductsProprio(Product $productsProprio): self
    {
        if ($this->products_proprio->contains($productsProprio)) {
            $this->products_proprio->removeElement($productsProprio);
            // set the owning side to null (unless already changed)
            if ($productsProprio->getUserIdProprio() === $this) {
                $productsProprio->setUserIdProprio(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProductsAche(): Collection
    {
        return $this->products_ache;
    }

    public function addProductsAche(Product $productsAche): self
    {
        if (!$this->products_ache->contains($productsAche)) {
            $this->products_ache[] = $productsAche;
            $productsAche->setUserIdAcheteur($this);
        }

        return $this;
    }

    public function removeProductsAche(Product $productsAche): self
    {
        if ($this->products_ache->contains($productsAche)) {
            $this->products_ache->removeElement($productsAche);
            // set the owning side to null (unless already changed)
            if ($productsAche->getUserIdAcheteur() === $this) {
                $productsAche->setUserIdAcheteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getUserProprio(): Collection
    {
        return $this->user_proprio;
    }

    public function addUserProprio(Product $userProprio): self
    {
        if (!$this->user_proprio->contains($userProprio)) {
            $this->user_proprio[] = $userProprio;
            $userProprio->setUserProprio($this);
        }

        return $this;
    }

    public function removeUserProprio(Product $userProprio): self
    {
        if ($this->user_proprio->contains($userProprio)) {
            $this->user_proprio->removeElement($userProprio);
            // set the owning side to null (unless already changed)
            if ($userProprio->getUserProprio() === $this) {
                $userProprio->setUserProprio(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getUserAcheteur(): Collection
    {
        return $this->user_acheteur;
    }

    public function addUserAcheteur(Product $userAcheteur): self
    {
        if (!$this->user_acheteur->contains($userAcheteur)) {
            $this->user_acheteur[] = $userAcheteur;
            $userAcheteur->setUserAcheteur($this);
        }

        return $this;
    }

    public function removeUserAcheteur(Product $userAcheteur): self
    {
        if ($this->user_acheteur->contains($userAcheteur)) {
            $this->user_acheteur->removeElement($userAcheteur);
            // set the owning side to null (unless already changed)
            if ($userAcheteur->getUserAcheteur() === $this) {
                $userAcheteur->setUserAcheteur(null);
            }
        }

        return $this;
    }
    


}
