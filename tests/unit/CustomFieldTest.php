<?php
use App\Models\CustomField;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


/*
 * Test strings for db column names  gathered from
 * http://www.omniglot.com/language/phrases/hovercraft.htm
 */
class CustomFieldTest extends \Codeception\TestCase\Test
{
  protected $tester;
  use DatabaseMigrations;

  public function testConstructor() {
    $customfield = new CustomField();
  }

  public function testFormat() {
    $customfield = factory(CustomField::class, 'customfield-ip')->make();
    $values = [
      'name' => $customfield->name,
      'format' => $customfield->format,
      'element' => $customfield->element,
    ];

    $this->assertEquals($customfield->getAttributes()['format'],CustomField::$PredefinedFormats['IP']); //this seems undocumented...
    $this->assertEquals($customfield->format,"IP");
  }

  public function testDbNameAscii() {
    $customfield = new CustomField();
    $customfield->name="My hovercraft is full of eels";
    $customfield->id = 1337;
    $this->assertEquals($customfield->convertUnicodeDbSlug(),"_snipeit_my_hovercraft_is_full_of_eels_1337");
  }

    // Western Europe
    public function testDbNameLatin() {
        $customfield=new CustomField();
        $customfield->name="My hovercraft is full of eels";
        $customfield->id = 1337;
        $this->assertEquals($customfield->convertUnicodeDbSlug(),"_snipeit_my_hovercraft_is_full_of_eels_1337");
    }


    // Asian
    public function testDbNameChinese() {
        $customfield=new CustomField();
        $customfield->name="我的氣墊船裝滿了鱔魚";
        $customfield->id = 1337;
        $this->assertEquals($customfield->convertUnicodeDbSlug(),"_snipeit_wo_de_qi_dian_chuan_zhuang_man_le_shan_yu_1337");
    }

    public function testDbNameJapanese() {
        $customfield=new CustomField();
        $customfield->name="私のホバークラフトは鰻でいっぱいです";
        $customfield->id = 1337;
        $this->assertEquals($customfield->convertUnicodeDbSlug(),"_snipeit_sinohohakurafutoha_manteihhaitesu_1337");
    }

    public function testDbNameKorean() {
        $customfield=new CustomField();
        $customfield->name="내 호버크라프트는 장어로 가득 차 있어요";
        $customfield->id = 1337;
        $this->assertEquals($customfield->convertUnicodeDbSlug(),"_snipeit_nae_hobeokeulapeuteuneun_jang_eolo_gadeug_1337");
    }

    // Nordic languages
    public function testDbNameNonLatinEuro() {
        $customfield=new CustomField();
        $customfield->name="Mój poduszkowiec jest pełen węgorzy";
        $customfield->id = 1337;
        $this->assertEquals($customfield->convertUnicodeDbSlug(),"_snipeit_moj_poduszkowiec_jest_pelen_wegorzy_1337");
    }

    //
    public function testDbNameTurkish() {
        $customfield=new CustomField();
        $customfield->name="Hoverkraftım yılan balığı dolu";
        $customfield->id = 1337;
        $this->assertEquals($customfield->convertUnicodeDbSlug(),"_snipeit_hoverkraftim_yilan_baligi_dolu_1337");
    }

    public function testDbNameArabic() {
        $customfield=new CustomField();
        $customfield->name="حَوّامتي مُمْتِلئة بِأَنْقَلَيْسون";
        $customfield->id = 1337;
        $this->assertEquals($customfield->convertUnicodeDbSlug(),"_snipeit_hwamty_mmtlyt_banqlyswn_1337");
    }



}
