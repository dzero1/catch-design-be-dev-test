<?php

namespace Tests\Unit;

use ErrorException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\Console\Exception\RuntimeException;
use Tests\TestCase;

class CustomerCSVImportTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Import customers CSV file test
     */
    public function test_importing_without_a_file(): void
    {
        $this->expectException(RuntimeException::class);
        $this->artisan('import:customer');
    }

    /**
     * Import customers CSV file test
     */
    public function test_customers_csv_file_import(): void
    {
        /* $csv_test_content = "
            id,first_name,last_name,email,gender,ip_address,company,city,title,website
            1,Laura,Richards,lrichards0@reverbnation.com,Female,81.192.7.99,Meezzy,Kallithéa,Biostatistician III,https://intel.com/aliquam/lacus/morbi/quis.png?ante=in&vivamus=sapien&tortor=iaculis&duis=congue&mattis=vivamus&egestas=metus&metus=arcu&aenean=adipiscing&fermentum=molestie&donec=hendrerit&ut=at&mauris=vulputate&eget=vitae&massa=nisl&tempor=aenean&convallis=lectus&nulla=pellentesque&neque=eget&libero=nunc&convallis=donec&eget=quis&eleifend=orci&luctus=eget&ultricies=orci&eu=vehicula&nibh=condimentum
            157,Denise,Castillo,dcastillo4c@buzzfeed.com,Female,60.164.23.31,Browsedrive,Shadili,Associate Professor,http://ovh.net/augue/a/suscipit/nulla/elit.jpg?hac=etiam&habitasse=pretium&platea=iaculis&dictumst=justo&etiam=in&faucibus=hac&cursus=habitasse&urna=platea&ut=dictumst&tellus=etiam&nulla=faucibus&ut=cursus&erat=urna&id=ut&mauris=tellus&vulputate=nulla&elementum=ut&nullam=erat&varius=id&nulla=mauris&facilisi=vulputate&cras=elementum&non=nullam&velit=varius&nec=nulla&nisi=facilisi&vulputate=cras
            973,Bonnie,Scott,bscottr0@nytimes.com,Female,131.155.53.206,Kazio,Daxi,Structural Engineer,https://com.com/consectetuer/adipiscing/elit/proin/risus.aspx?interdum=nulla&in=tempus&ante=vivamus&vestibulum=in&ante=felis&ipsum=eu&primis=sapien&in=cursus&faucibus=vestibulum&orci=proin&luctus=eu&et=mi&ultrices=nulla
        "; */

        $this->artisan('import:customer '.__DIR__.'/../../../customers.csv')
            ->expectsOutput('Importing customers from customers.csv')
            ->expectsOutput('Done!');

        $this->assertDatabaseHas('customers', [
            'id' => '1',
            'first_name' => 'Laura',
            'last_name' => 'Richards',
            'email' => 'lrichards0@reverbnation.com',
            'gender' => 'Female',
        ]);

        $this->assertDatabaseHas('customers', [
            'id' => '157',
            'first_name' => 'Denise',
            'last_name' => 'Castillo',
            'email' => 'dcastillo4c@buzzfeed.com',
            'gender' => 'Female',
        ]);

        $this->assertTrue(true);
    }
}
