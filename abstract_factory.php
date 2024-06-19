<?php
//abstract factory
    
// interface PhoneFactory {
//     public function createPhone(string $phoneType): Phone;
// }

// interface Phone {
//     public function details();
//     public function moredetails();
// }

// class ProductFactory implements PhoneFactory {
//     public function createPhone(string $phoneType): Phone {
//         if (strpos($phoneType, 'GalaxyS') === 0) {
//             return new GalaxySSeries();
//         } elseif (strpos($phoneType, 'GalaxyZFlip') === 0) {
//             return new GalaxyFlipSeries();
//         }
//         return null;
//     }
// }

// class GalaxyS23Ultra implements Phone {
//     public function details() {
//         echo "<h3><b>Galaxy S23 Ultra</b></h3>";
//         echo "<p>Starts from <span class='price'>Php 81,990.00</span></p>";
//     }
//     public function moredetails(){
//         echo "<h5>Description</h5>";
//         echo "<p style='justify-content:space-evenly'>The <span class='price'>Samsung Galaxy S23 Ultra</span> is the headliner of the S23 series. 
//             Specifications are top-notch including 6.8-inch Dynamic AMOLED display with 
//             120Hz refresh rate, Snapdragon 8 Gen 2 processor, 5000mAh battery, up to 12gigs of RAM, 
//             and 1TB of storage. In the camera department, a quad-camera setup is presented with two telephoto sensors.</p>";
//         echo "<br><h5>Available Storage</h5>";
//         echo "<p>12GB/256GB | <span class='price'>Php 81,990.00</span></p>";
//         echo "<p>12GB/512GB | <span class='price'>Php 89,990.00</span></p>";
//         echo "<p>12GB/1TB | <span class='price'>Php 103,990.00</span></p>";
//     }
//     public function populate(array $data) {
//         $this->id = $data['id'];
//         $this->Phone = $data['Phone'];
//         $this->price = $data['price'];
//         $this->quantity = $data['quantity'];
//         $this->image = $data['image'];
//     }
// }

// class GalaxyS23Plus implements Phone {
//     public function details() {
//         echo "<h3><b>Galaxy S23+</b></h3>";
//         echo "<p>Starts from <span class='price'>Php 68,990.00</span></p>";
//     }
//     public function moredetails(){
//         echo "<h5>Description</h5>";
//         echo "<p style='justify-content:space-evenly'>The <span class='price'>Samsung Galaxy S23+</span> is the bigger sibling 
//             of the regular Galaxy S23 with it’s 6.6-inch Dynamic AMOLED display with 120Hz refresh rate. Specs also include Qualcomm Snapdragon 8 Gen 2 
//                 cessor, 4700mAh battery and Triple camera setup on the back.</p>";
//         echo "<br><h5>Available Storage</h5>";
//         echo "<p>8GB/256GB | <span class='price'>Php 68,990.00</span></p>";
//         echo "<p>8GB/512GB | <span class='price'>Php 76,990.00</span></p>";
//     }
//     public function populate(array $data) {
//         $this->id = $data['id'];
//         $this->Phone = $data['Phone'];
//         $this->price = $data['price'];
//         $this->quantity = $data['quantity'];
//         $this->image = $data['image'];
//     }
// }

// class GalaxyS23 implements Phone {
//     public function details() {
//         echo "<h3><b>Galaxy S23</b></h3>";
//         echo "<p>Starts from <span class='price'>Php 53,990.00</span></p>";
//     }
//     public function moredetails(){
//         echo "<h5>Description</h5>";
//         echo "<p style='justify-content:space-evenly'>The <span class='price'>Samsung Galaxy S23</span> specs are top-notch including a Snapdragon 8 Gen 2 
//             chipset, 8GB RAM coupled with 128/256GB storage, and a 3900mAh battery. The phone sports a 6.1-inch Dynamic AMOLED display with an adaptive 120Hz 
//             refresh rate. In the camera department there is a Triple-sensor setup is present.</p>";
//         echo "<br><h5>Available Storage</h5>";
//         echo "<p>8GB/128GB | <span class='price'>Php 53,990.00</span></p>";
//         echo "<p>8GB/256GB | <span class='price'>Php 57,990.00</span></p>";
//     }
//     public function populate(array $data) {
//         $this->id = $data['id'];
//         $this->Phone = $data['Phone'];
//         $this->price = $data['price'];
//         $this->quantity = $data['quantity'];
//         $this->image = $data['image'];
//     }
// }

// class GalaxyZFlip5 implements Phone {
//     public function details() {
//         echo "<h3><b>Galaxy Z Flip 5</b></h3>";
//         echo "<p>Starts from <span class='price'>Php 64,990.00</span></p>";
//     }
//     public function moredetails(){
//         echo "<h5>Description</h5>";
//         echo "<p style='justify-content:space-evenly'>The <span class='price'>Samsung Galaxy Z Flip 5</span> is Samsung's 5th-generation foldable phone
//         that launched in August 2023. It has a 6.7-inch screen with 120Hz refresh rate, and a powerful Snapdragon 8 Gen 2 chipset with a battery capacity of
//         3700mAh. The dual 12MP camera supports ultra-wide photos that is great for taking astonishing zoomed-in photos, and has a storage of either 256GB
//         or 512GB with 8GB of RAM. The 5th-gen foldable comes with the following colors; Mint, Graphite, Cream and Lavender.</p>";
//         echo "<br><h5>Available Storage</h5>";
//         echo "<p>8GB/256GB | <span class='price'>Php 64,990.00</span></p>";
//         echo "<p>8GB/512GB | <span class='price'>Php 71,990.00</span></p>";
//     }
//     public function populate(array $data) {
//         $this->id = $data['id'];
//         $this->Phone = $data['Phone'];
//         $this->price = $data['price'];
//         $this->quantity = $data['quantity'];
//         $this->image = $data['image'];
//     }
// }

// class GalaxyZFlip4 implements Phone {
//     public function details() {
//         echo "<h3><b>Galaxy Z Flip 4</b></h3>";
//         echo "<p>Starts from <span class='price'>Php 43,990.00</span></p>";
//     }
//     public function moredetails(){
//         echo "<h5>Description</h5>";
//         echo "<p style='justify-content:space-evenly'>The <span class='price'>Samsung Galaxy Z Flip 4</span> is what comes after its previous successor that
//         launched in August 2022. It measures in at 6.7-inch with Full HD+ resolution and 120Hz refresh rate. It has brought the latest Snapdragon 8 Plus
//         Gen 1 as its processor, and an extended battery  capacity of 3700 mAh, with 8GB of RAM, up to 512 GB storage with no SD slot. It comes with a variety
//         of finishes; Bora Purple, Graphite, Pink Gold and Blue.</p>";
//         echo "<br><h5>Available Storage</h5>";
//         echo "<p>8GB/128GB | <span class='price'>Php 43,990.00</span></p>";
//         echo "<p>8GB/256GB | <span class='price'>Php 47,990.00</span></p>";
//         echo "<p>8GB/512GB | <span class='price'>Php 50,990.00</span></p>";
//     }
//     public function populate(array $data) {
//         // Implement the populate method to set object properties based on $data
//         $this->id = $data['id'];
//         $this->Phone = $data['Phone'];
//         $this->price = $data['price'];
//         $this->quantity = $data['quantity'];
//         $this->image = $data['image'];
//     }
// }

// class GalaxyZFlip3 implements Phone {
//     public function details() {
//         echo "<h3><b>Galaxy Z Flip 3</b></h3>";
//         echo "<p>Starts from <span class='price'>Php 18,450.00</span></p>";
//         }
//     public function moredetails(){
//         echo "<h5>Description</h5>";
//         echo "<p style='justify-content:space-evenly'>The <span class='price'>Samsung Galaxy Z Flip 3</span> is its 3rd-generation foldables of the Z Flip
//             with a new design. It has 6.7-inch Super AMOLED display with a smooth 120Hz refresh rate. It provides Qualcomm Snapdragon 888 processor, and has
//             either 128 or 256 GB internal storage, with 8GB of RAM. With its 12MP dual camera on the back, it can capture 4k videos up to 60 fps, and the
//             foldable device comes with 3300mAh non-removable battery. It comes in Phantom Black, Green, Lavender, Cream, White, Pink, and Gray.</p>";
//         echo "<br><h5>Available Storage</h5>";
//         echo "<p>8GB/128GB | <span class='price'>Php 18,450.00</span></p>";
//         echo "<p>8GB/256GB | <span class='price'>Php 22,450.00</span></p>";
//     }
//     public function populate(array $data) {
//         $this->id = $data['id'];
//         $this->Phone = $data['Phone'];
//         $this->price = $data['price'];
//         $this->quantity = $data['quantity'];
//         $this->image = $data['image'];
//     }
// }

// class GalaxySSeriesFactory implements PhoneFactory {
//     public function createPhone(string $phoneType): Phone {
//         if ($phoneType === 'Galaxy S23 Ultra') {
//             return new GalaxyS23Ultra();
//         } elseif ($phoneType === 'Galaxy S23 Plus') {
//             return new GalaxyS23Plus();
//         } elseif ($phoneType === 'Galaxy S23') {
//             return new GalaxyS23();
//         } else {
//             return new GalaxyS23();
//         }
//     }
// }

// class GalaxyFlipSeriesFactory implements PhoneFactory {
//     public function createPhone(string $phoneType): Phone {
//         if($phoneType === 'Galaxy Z Flip 5'){
//             return new GalaxyZFlip5();
//         }elseif($phoneType === 'Galaxy Z Flip 4'){
//             return new GalaxyZFlip4();
//         }elseif($phoneType === 'Galaxy Z Flip 3'){
//             return new GalaxyZFlip3();
//         }
//         return new GalaxyZFlip5();
//     }
// }

//     $galaxySSeriesFactory = new GalaxySSeriesFactory();
//     $galaxyFlipSeriesFactory = new GalaxyFlipSeriesFactory();


include_once ("db_connection.php");

//abstract factory
interface ElectronicsFactory {
    public function createPhone(string $phoneType): Phone;
    public function createEarphones(string $earphoneType): Earphones;
}

trait PopulateTrait { //Eliminate repetition for populate on each class()
    public function populate(array $data) {
        // Implement the populate method to set object properties based on $data
        $this->id = $data['id'];
        $this->Product = $data['Product'];
        $this->price = $data['price'];
        $this->quantity = $data['quantity'];
        $this->image = $data['image'];
    }
}

//product interfaces
interface Phone { //no change
    public function details();
    public function moredetails();
    //public function populate(array $data);
}

//Phone products
class GalaxyS23Ultra implements Phone {
    public function details() {
        echo "<h3><b>Galaxy S23 Ultra</b></h3>";
        echo "<p>Starts from <span class='price'>Php 81,990.00</span></p>";
    }
    public function moredetails(){
        echo "<h5>Description</h5>";
        echo "<p style='justify-content:space-evenly'>The <span class='price'>Samsung Galaxy S23 Ultra</span> is the headliner of the S23 series. 
            Specifications are top-notch including 6.8-inch Dynamic AMOLED display with 
            120Hz refresh rate, Snapdragon 8 Gen 2 processor, 5000mAh battery, up to 12gigs of RAM, 
            and 1TB of storage. In the camera department, a quad-camera setup is presented with two telephoto sensors.</p>";
        echo "<br><h5>Available Storage</h5>";
        echo "<p>12GB/256GB | <span class='price'>Php 81,990.00</span></p>";
        echo "<p>12GB/512GB | <span class='price'>Php 89,990.00</span></p>";
        echo "<p>12GB/1TB | <span class='price'>Php 103,990.00</span></p>";
    }
    use PopulateTrait;
}

class GalaxyS23Plus implements Phone {
    public function details() {
        echo "<h3><b>Galaxy S23+</b></h3>";
        echo "<p>Starts from <span class='price'>Php 68,990.00</span></p>";
    }
    public function moredetails(){
        echo "<h5>Description</h5>";
        echo "<p style='justify-content:space-evenly'>The <span class='price'>Samsung Galaxy S23+</span> is the bigger sibling 
            of the regular Galaxy S23 with it’s 6.6-inch Dynamic AMOLED display with 120Hz refresh rate. Specs also include Qualcomm Snapdragon 8 Gen 2 
                cessor, 4700mAh battery and Triple camera setup on the back.</p>";
        echo "<br><h5>Available Storage</h5>";
        echo "<p>8GB/256GB | <span class='price'>Php 68,990.00</span></p>";
        echo "<p>8GB/512GB | <span class='price'>Php 76,990.00</span></p>";
    }
    use PopulateTrait;
}

class GalaxyS23 implements Phone {
    public function details() {
        echo "<h3><b>Galaxy S23</b></h3>";
        echo "<p>Starts from <span class='price'>Php 53,990.00</span></p>";
    }
    public function moredetails(){
        echo "<h5>Description</h5>";
        echo "<p style='justify-content:space-evenly'>The <span class='price'>Samsung Galaxy S23</span> specs are top-notch including a Snapdragon 8 Gen 2 
            chipset, 8GB RAM coupled with 128/256GB storage, and a 3900mAh battery. The phone sports a 6.1-inch Dynamic AMOLED display with an adaptive 120Hz 
            refresh rate. In the camera department there is a Triple-sensor setup is present.</p>";
        echo "<br><h5>Available Storage</h5>";
        echo "<p>8GB/128GB | <span class='price'>Php 53,990.00</span></p>";
        echo "<p>8GB/256GB | <span class='price'>Php 57,990.00</span></p>";
    }
    use PopulateTrait;
}

class GalaxyZFlip5 implements Phone {
    public function details() {
        echo "<h3><b>Galaxy Z Flip 5</b></h3>";
        echo "<p>Starts from <span class='price'>Php 64,990.00</span></p>";
    }
    public function moredetails(){
        echo "<h5>Description</h5>";
        echo "<p style='justify-content:space-evenly'>The <span class='price'>Samsung Galaxy Z Flip 5</span> is Samsung's 5th-generation foldable phone
        that launched in August 2023. It has a 6.7-inch screen with 120Hz refresh rate, and a powerful Snapdragon 8 Gen 2 chipset with a battery capacity of
        3700mAh. The dual 12MP camera supports ultra-wide photos that is great for taking astonishing zoomed-in photos, and has a storage of either 256GB
        or 512GB with 8GB of RAM. The 5th-gen foldable comes with the following colors; Mint, Graphite, Cream and Lavender.</p>";
        echo "<br><h5>Available Storage</h5>";
        echo "<p>8GB/256GB | <span class='price'>Php 64,990.00</span></p>";
        echo "<p>8GB/512GB | <span class='price'>Php 71,990.00</span></p>";
    }
    use PopulateTrait;
}

class GalaxyZFlip4 implements Phone {
    public function details() {
        echo "<h3><b>Galaxy Z Flip 4</b></h3>";
        echo "<p>Starts from <span class='price'>Php 43,990.00</span></p>";
    }
    public function moredetails(){
        echo "<h5>Description</h5>";
        echo "<p style='justify-content:space-evenly'>The <span class='price'>Samsung Galaxy Z Flip 4</span> is what comes after its previous successor that
        launched in August 2022. It measures in at 6.7-inch with Full HD+ resolution and 120Hz refresh rate. It has brought the latest Snapdragon 8 Plus
        Gen 1 as its processor, and an extended battery  capacity of 3700 mAh, with 8GB of RAM, up to 512 GB storage with no SD slot. It comes with a variety
        of finishes; Bora Purple, Graphite, Pink Gold and Blue.</p>";
        echo "<br><h5>Available Storage</h5>";
        echo "<p>8GB/128GB | <span class='price'>Php 43,990.00</span></p>";
        echo "<p>8GB/256GB | <span class='price'>Php 47,990.00</span></p>";
        echo "<p>8GB/512GB | <span class='price'>Php 50,990.00</span></p>";
    }
    use PopulateTrait;
}

class GalaxyZFlip3 implements Phone {
    public function details() {
        echo "<h3><b>Galaxy Z Flip 3</b></h3>";
        echo "<p>Starts from <span class='price'>Php 18,450.00</span></p>";
        }
    public function moredetails(){
        echo "<h5>Description</h5>";
        echo "<p style='justify-content:space-evenly'>The <span class='price'>Samsung Galaxy Z Flip 3</span> is its 3rd-generation foldables of the Z Flip
            with a new design. It has 6.7-inch Super AMOLED display with a smooth 120Hz refresh rate. It provides Qualcomm Snapdragon 888 processor, and has
            either 128 or 256 GB internal storage, with 8GB of RAM. With its 12MP dual camera on the back, it can capture 4k videos up to 60 fps, and the
            foldable device comes with 3300mAh non-removable battery. It comes in Phantom Black, Green, Lavender, Cream, White, Pink, and Gray.</p>";
        echo "<br><h5>Available Storage</h5>";
        echo "<p>8GB/128GB | <span class='price'>Php 18,450.00</span></p>";
        echo "<p>8GB/256GB | <span class='price'>Php 22,450.00</span></p>";
    }
    use PopulateTrait;
}

//2nd product line
interface Earphones { 
    public function details();
    public function moredetails();
    //public function populate(array $data);
}

class MarshallModeEQ implements Earphones {
    public function details() {
        echo "<h3><b>Marshall Mode EQ</b></h3>";
        echo "<p>Starts from <span class='price'>Php 3,750.00</span></p>";
    }
    public function moredetails(){
        echo "<p style='justify-content:space-evenly'><span class='price'>Mode EQ</span>, a product of Marshall, is an
        in-ear headphone product offered by Marshall, It offers huge sound in a small package. Customised drivers deliver
        high-output sound at minimal distortion. With unique in-ear design that anchors to your ear, Mode comes with four
        different size sleeves allowing you to find the perfect fit.</p>";
    }
    use PopulateTrait;
}

class SamsungGalaxyBuds2 implements Earphones {
    public function details() {
        echo "<h3><b>Samsung Galaxy Buds 2</b></h3>";
        echo "<p>Starts from <span class='price'>Php 12,990.00</span></p>";
    }
    public function moredetails(){
        echo "<p style='justify-content:space-evenly'>The <span class='price'>Galaxy Buds 2</span>  opens a new world of sound with
        well-balanced audio, lightweight comfort fit, Active Noise Cancellation and seamless connectivity to your Galaxy phone and 
        watch. Intuitive controls and powerful sound keep you immersed when working out, gaming or jamming to your beats.</p>"; 
    }
    use PopulateTrait;
}

class SamsungAKG implements Earphones { 
    public function details() {
        echo "<h3><b>Samsung AKG</b></h3>";
        echo "<p>Starts from <span class='price'>Php 400.00</span></p>";
    }
    public function moredetails(){
        echo "<p style='justify-content:space-evenly'><span class='price'>Samsung Earphones</span> tuned by AKG, 
        provides an incredibly clear, authentic-sounding, and balanced output - Enjoy crisp, rich, and balanced sounds bass 
        across the entire audio spectrum with in-line remote control. Let your music flow freely. Its in-ear headphones 
        are housed in a premium, sleek metal finish and feature tangle-free fabric cable for greater manageability and 
        ease of use so you can listen to your favorite music without the distraction of messy wiring. 3.5mm jack wiring. </p>";
    }
    use PopulateTrait;
}

// Implement the creation logic for Phones objects
class PhoneFactory implements ElectronicsFactory {
    public function createPhone(string $phoneType): Phone {
        $className = str_replace(' ', '', $phoneType);
        $className = ucfirst($className);
        $className = $className;
    
        // Debugging: output the class name
        //echo "Creating class: $className<br>";
    
        // Check if the class exists, return null otherwise
        if (class_exists($className) && in_array('Phone', class_implements($className))) {
            return new $className();
        } else {
            throw new Exception("Class $className not found or does not implement Phone interface");
        }
    }    

    public function createEarphones(string $earphoneType): Earphones {
        return new Earphones3();
    }
}

// Implement the creation logic for Earphones objects
class EarphonesFactory implements ElectronicsFactory {
    public function createPhone(string $phoneType): Phone {
        return new GalaxyZFlip3(); // Change this if you have specific logic for Earphones
    }

    public function createEarphones(string $earphoneType): Earphones {
        $className = str_replace(' ', '', $earphoneType);
        $className = ucfirst($className);

        // Check if the class exists, return null otherwise
        return class_exists($className) ? new $className() : null;
    }
}

$phoneFactory = new PhoneFactory();
$earphonesFactory = new EarphonesFactory();
?>