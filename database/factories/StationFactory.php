<?php


namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Station>
 */
class StationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $adminRoleWeb = Role::where('name', 'admin')->where('guard_name', 'web')->first();
        $adminRoleApi = Role::where('name', 'admin')->where('guard_name', 'api')->first();
        $superAdminRoleWeb = Role::where('name', 'super admin')->where('guard_name', 'web')->first();
        $superAdminRoleApi = Role::where('name', 'super admin')->where('guard_name', 'api')->first();

        $usersWithRoles = User::whereHas('roles', function ($query) use ($adminRoleWeb, $adminRoleApi, $superAdminRoleWeb, $superAdminRoleApi) {
            $query->whereIn('role_id', [$adminRoleWeb->id, $superAdminRoleWeb->id])
                  ->orWhereIn('role_id', [$adminRoleApi->id, $superAdminRoleApi->id]);
        })->inRandomOrder()->get();

        $names = [
            'megenagna-station', 'mexico-station', 'tuludimtu-station', 'goro-station', 'ayertena-station',
            'yekabado-station', 'koyefiche-station', 'addisugebeya-station', 'merkato-station', 'torhayloch-station',
            'piassa-station', '4kilo-station', 'bole-station', 'zoble-station', 'bethel-station', '22-station',
            'cathedral-station', 'hillside-station', 'downtown-station', 'friends-station', 'kefita-station',
            'entoto-station', 'buna-station', 'tea-station', '5kil-station', '6kilo-station', 'torhailoch-station',
            'molla-station', 'gofa-station', 'kaliti-station', 'summit-station', 'gulele-station',
            'akaki-station', 'sarbet-station', 'bambis-station', 'meskel-square-station', 'yeka-station',
            'burayu-station', 'abinet-station', 'shola-station', 'lem-hotel-station', 'gotera-station',
            'arasement-station', 'asay-station', 'nifas-silk-station', 'gofa-gebriel-station', 'sebatamit-station',
            'sebategna-station', 'asko-station', 'bole-mall-station', 'wello-sefer-station', 'atlas-station',
            'lafto-station', 'janmeda-station', 'kotebe-station', 'yeka-abado-station', 'ayalew-korkoro-station',
            'alert-hospital-station', 'summit-condos-station', 'aerodrome-station', 'torhailoch-bridge-station',
            'atlas-hotel-station', 'goro-condos-station', 'pecan-station', 'sar-bet-station', 'wereda-5-station',
            'lebu-station', 'meskel-flower-station', 'galan-station', 'furi-station', 'gotera-construction-station',
            'hager-fikir-theater-station', 'gurd-sholla-station', 'kechene-station', 'mesqel-station', 'qera-station',
            'asku-station', 'hayat-station', 'ras-hotel-station', 'roosevelt-station', 'zafer-station',
            'hidase-station', 'kaldis-station', 'lul-bet-station', 'sheraton-station', 'ghion-station',
            'ethiopia-airlines-station', 'sabiyan-station', 'bole-airport-station', 'cambridge-station',
            'sheger-park-station', 'ware-bakery-station', 'abebe-bikila-station', 'hilton-hotel-station',
            'old-airport-station', 'salem-station', 'british-council-station', 'sidist-kilo-station',
            'betelhem-station', 'torhailoch-market-station', 'adwa-bridge-station', 'temenja-yaj-station',
            'bola-condo-station', 'rasta-condo-station', 'jemo-station', 'keranyo-station', 'lebu-tele-station',
            'golf-club-station', 'edna-mall-station', 'amen-hotel-station', 'gedam-sefer-station', 'beshale-station',
            'abado-condos-station', 'debub-station', 'semien-hotel-station', 'dembel-station', 'blue-nile-station',
            'gihon-hotel-station', 'entoto-condo-station', 'hager-fikir-station', 'uraga-station', 'gerji-station',
            'saris-station', 'jax-hotel-station', 'zilal-station', 'alem-bank-station', 'lala-condos-station',
            'lebam-station', 'red-cross-station', 'commercial-bank-station', 'hawassa-station', 'adama-station',
            'nazret-station', 'debre-zeyit-station', 'bahirdar-station', 'harar-station', 'dire-dawa-station',
            'mekele-station', 'lalibela-station', 'kombolcha-station', 'axum-station', 'gondar-station', 'sodore-station',
            'waliso-station', 'hosana-station', 'ambo-station', 'welkite-station', 'jimma-station', 'arbaminch-station',
            'shashemene-station', 'bale-robe-station', 'adigrat-station', 'assosa-station', 'gambella-station',
            'bonga-station', 'gimbi-station', 'nekemte-station', 'hossana-station', 'dodola-station', 'jinjiga-station',
            'debark-station', 'lalibela-airport-station', 'erib-station', 'sala-station', 'chancho-station', 'filweha-station',
            'ayertena-betoch-station', 'gofa-mazoria-station', 'kasanchis-station', 'abnet-station', 'jemma-matahara-station',
            'kebena-station', 'yoseph-church-station', 'pharmacy-station', 'universities-station', 'meles-village-station',
            'wabe-shebele-station', 'soddo-station', 'durame-station', 'kibremengist-station', 'mizan-teferi-station',
            'debre-birhan-station', 'legambo-station', 'yirgalem-station', 'mitu-station', 'arba-station', 'moyale-station',
            'borena-station', 'yabelo-station', 'dejen-station', 'sheno-station', 'arjo-station', 'shashogo-station',
            'dubti-station', 'dere-station', 'kuriftu-lodge-station', 'awash-melka-station', 'awash-park-station',
            'dikula-station', 'logiya-station', 'dimma-station', 'goba-station', 'wereta-station', 'areka-station',
            'sajo-station', 'bichena-station', 'guder-station', 'dabano-station', 'bure-station', 'fasilo-station',
            'koye-feche-station', 'awash-seger-station', 'teppi-station', 'gorgora-station', 'mille-station',
            'serbo-station', 'debremarkos-station', 'dilla-station', 'metu-station', 'alem-gena-station', 'jijiga-station',
            'ginda-station', 'axum-park-station', 'addis-alem-station', 'bishoftu-resort-station', 'gode-station',
            'bako-station', 'abomsa-station', 'bore-station', 'aleta-wondo-station', 'hagere-mariam-station', 'alibo-station',
            'sala-dingay-station', 'shashamane-airport-station', 'yerer-station', 'addis-ketema-station', 'woldia-station',
            'dubar-station', 'hurso-station', 'bishoftu-station', 'haramaya-station', 'fichu-station', 'lemma-guya-station',
            'hadiya-station', 'mehoni-station', 'mesqan-station', 'yabelo-park-station', 'negele-borena-station',
            'shombela-station', 'mosobo-hotel-station', 'wochale-station', 'fiti-station', 'lesla-station',
            'wacha-station', 'gubrye-station', 'dere-washington-station', 'metema-station', 'bare-station', 'mida-station',
            'medani-alem-station', 'kile-station', 'turmi-station', 'oyeda-station', 'dembela-station', 'zarima-station'
        ];


        // Ensure the name is unique
        $name = fake()->unique()->randomElement($names);

        return [
            'name' => $name,
            'location' => fake()->randomElement([
                'megenagna', 'mexico', 'tuludimtu', 'goro', 'ayertena', 'yekabado', 'koyefiche', 'addisugebeya', 'merkato', 'torhayloch', 'piassa', '4kilo', 'bole'
            ]),
            'created_by' => $usersWithRoles->isNotEmpty() ? $usersWithRoles->first()->id : null,
            'updated_by' => $usersWithRoles->isNotEmpty() ? $usersWithRoles->random()->id : null,
        ];
    }
}
