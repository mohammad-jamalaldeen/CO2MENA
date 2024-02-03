<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('countries')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		$countries = [
			[
				'code' => 'AF', 
				'name' => 'Afghanistan',
				'hotel_factor' => NULL, 
				'home_factor' => '0.20558641368215'
			],
			[ 
				'code' => 'AL',
				'name' => 'Åland Islands', 
				'hotel_factor' => NULL,
				'home_factor' =>  '0.52194015744422'
			],
			[ 
				'code' => 'AL', 
				'name' => 'Albania', 
				'hotel_factor' => NULL, 
				'home_factor' => '0.042965859968045'
			],
			[ 
				'code' => 'DZ', 
				'name' => 'Algeria', 
				'hotel_factor' => NULL, 
				'home_factor' => '0.42925727276327'
			],
			[ 
				'code' => 'AS', 
				'name' => 'American Samoa', 
				'hotel_factor' => NULL,
				'home_factor' => '0.54383531185156'
			],
			[ 
				'code' => 'AD', 
				'name' => 'Andorra', 
				'hotel_factor' => NULL,
				'home_factor' => '0.042965859968045'
			],
			[ 
				'code' => 'AO', 
				'name' => 'Angola', 
				'hotel_factor' => NULL,
				'home_factor' => '0.42560268887001'
			],
			[ 
				'code' => 'AI', 
				'name' => 'Anguilla', 
				'hotel_factor' => NULL,
				'home_factor' => '0.49326841036194'
			],
			[ 
				'code' => 'AQ', 
				'name' => 'Antarctica', 
				'hotel_factor' => NULL,
				'home_factor' =>  '0.52194015744422'
			],
			[ 
				'code' => 'AG', 
				'name' => 'Antigua and Barbuda', 
				'hotel_factor' => NULL,
				'home_factor' => '0.52707676315371'
			],
			[ 
				'code' => 'AR', 
				'name' => 'Argentina', 
				'hotel_factor' =>'77.080424308057',
				'home_factor' =>  '0.35019264315809'
			],
			[ 
				'code' => 'AM', 
				'name' => 'Armenia', 
				'hotel_factor' => NULL,
				'home_factor' =>  '0.24658507460916'
			],
			[ 
				'code' => 'AW', 
				'name' => 'Aruba', 
				'hotel_factor' => NULL,
				'home_factor' =>  '0.45038597458733'
			],
			[ 
				'code' => 'AU', 
				'name' => 'Australia', 
				'hotel_factor' =>'51.466471723405', 
				'home_factor' => '0.41157690403857'
			],
			[ 
				'code' => 'AT', 
				'name' => 'Austria', 
				'hotel_factor' =>'18.725744293613', 
				'home_factor' => '0.13381488072164'
			],
			[ 
				'code' => 'AZ', 
				'name' => 'Azerbaijan',
				'hotel_factor' => NULL,
				'home_factor' => '0.41056394652154'
			],
			[ 
				'code' => 'BS', 
				'name' => 'Bahamas', 
				'hotel_factor' => NULL, 
				'home_factor' => '0.46188517641738'
			],
			[ 
				'code' => 'BH', 
				'name' => 'Bahrain', 
				'hotel_factor' => NULL, 
				'home_factor' => '0.4749283188596'
			],
			[ 
				'code' => 'BD', 
				'name' => 'Bangladesh', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.5018440252892'
			],
			[ 
				'code' => 'BB', 
				'name' => 'Barbados', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.50216722303591'
			],
			[ 
				'code' => 'BY', 
				'name' => 'Belarus', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.33609087260323'
			],
			[ 
				'code' => 'BE', 
				'name' => 'Belgium', 
				'hotel_factor' =>'16.035151683704', 
				'home_factor' =>'0.16548906342148'
			],
			[ 
				'code' => 'BZ', 
				'name' => 'Belize', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.30420852093073'
			],
			[ 
				'code' => 'BJ', 
				'name' => 'Benin', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.62368500550499'
			],
			[ 
				'code' => 'BM', 
				'name' => 'Bermuda', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.37414293482076'
			],
			[ 
				'code' => 'BT', 
				'name' => 'Bhutan', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.042965859968045'
			],
			[ 
				'code' => 'BO', 
				'name' => 'Bolivia (Plurinational State of)', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.40899442928747'
			],
			[ 
				'code' => 'BO', 
				'name' => 'Bonaire, Sint Eustatius and Saba', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.52194015744422'
			],
			[ 
				'code' => 'BA', 
				'name' => 'Bosnia and Herzegovina', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.86350763991834'
			],
			[ 
				'code' => 'BW', 
				'name' => 'Botswana', 
				'hotel_factor' => NULL, 
				'home_factor' =>'1.1794675325574'
			],
			[ 
				'code' => 'BV', 
				'name' => 'Bouvet Island', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.52194015744422'
			],
			[ 
				'code' => 'BR', 
				'name' => 'Brazil', 
				'hotel_factor' =>'16.769809675026', 
				'home_factor' =>'0.20135031432079'
			],
			[ 
				'code' => 'IO', 
				'name' => 'British Indian Ocean Territory', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.52194015744422'
			],
			[ 
				'code' => 'BR', 
				'name' => 'British Virgin Islands', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.45647119218874'
			],
			[ 
				'code' => 'BN', 
				'name' => 'Brunei Darussalam', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.3787192168459'
			],
			[ 
				'code' => 'BG', 
				'name' => 'Bulgaria', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.54701997981584'
			],
			[ 
				'code' => 'BF', 
				'name' => 'Burkina Faso', 
				'hotel_factor' => NULL,
				'home_factor' => '0.63577148321833'],
			[ 
				'code' => 'BI', 
				'name' => 'Burundi', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.31649915741232'
			],
			[ 
				'code' => 'CV', 
				'name' => 'Cabo Verde', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.54382104449824'
			],
			[ 
				'code' => 'KH', 
				'name' => 'Cambodia', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.58031421025947'
			],
			[ 
				'code' => 'CM', 
				'name' => 'Cameroon', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.27505253950476'
			],
			[ 
				'code' => 'CA', 
				'name' => 'Canada', 
				'hotel_factor' => '23.002166292334', 
				'home_factor' =>'0.2314220024368'
			],
			[ 
				'code' => 'KY', 
				'name' => 'Cayman Islands', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.40084272912996'
			],
			[ 
				'code' => 'CF', 
				'name' => 'Central African Republic', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.22446122778617'
			],
			[ 
				'code' => 'TD', 
				'name' => 'Chad', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.65459884101819'
			],
			[ 
				'code' => 'CL', 
				'name' => 'Chile', 
				'hotel_factor' =>'38.503511174022', 
				'home_factor' =>'0.33910535256264'
			],
			[ 
				'code' => 'CN', 
				'name' => 'China', 
				'hotel_factor' =>'76.737627146438', 
				'home_factor' =>'0.49376254486561'
			],
			[ 
				'code' => 'CN', 
				'name' => 'China, Hong Kong Special Administrative Region', 
				'hotel_factor' =>NULL, 
				'home_factor' =>'0.39638132565444'
			],
			[ 
				'code' => 'CN', 
				'name' => 'China, Macao Special Administrative Region', 
				'hotel_factor' =>NULL, 
				'home_factor' =>'0.23879807608323'
			],
			[ 
				'code' => 'CX', 
				'name' => 'Christmas Island', 
				'hotel_factor' =>NULL, 
				'home_factor' =>'0.52194015744422'
			],
			[ 
				'code' => 'CC', 
				'name' => 'Cocos (Keeling) Islands', 
				'hotel_factor' =>NULL, 
				'home_factor' =>'0.52194015744422'
			],
			[ 
				'code' => 'CO', 
				'name' => 'Colombia',  
				'hotel_factor' => '18.691466461785', 
				'home_factor' =>'0.23088184773797'
			],
			[ 
				'code' => 'KM', 
				'name' => 'Comoros', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.64662739326434'
			],
			[ 
				'code' => 'CG', 
				'name' => 'Congo', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.34155173934886'
			],
			[ 
				'code' => 'CK', 
				'name' => 'Cook Islands', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.32623537833265'
			],
			[ 
				'code' => 'CR', 
				'name' => 'Costa Rica', 
				'hotel_factor' => '11.096858841059', 
				'home_factor' =>'0.14515986502335'
			],
			[ 
				'code' => 'HR', 
				'name' => 'Croatia', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.23651011276602'
			],
			[ 
				'code' => 'CU', 
				'name' => 'Cuba', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.59818585112493'
			],
			[ 
				'code' => 'CY', 
				'name' => 'Cyprus', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.44080065088862'
			],
			[ 
				'code' => 'CW', 
				'name' => 'Curaçao', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.46633133149336'
			],
			[ 
				'code' => 'CZ', 
				'name' => 'Czechia', 
				'hotel_factor' => NULL,
				'home_factor' => '0.50073099211071'],
			[ 
				'code' => 'CD', 
				'name' => 'Democratic People\'s Republic of Korea', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.40677030996088'
			],
			[ 
				'code' => 'CD', 
				'name' => 'Democratic Republic of the Congo', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.043396846853645'
			],
			[ 
				'code' => 'DK', 
				'name' => 'Denmark', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.23512927427729'
			],
			[ 
				'code' => 'DJ', 
				'name' => 'Djibouti', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.63885334743701' 
			],
			[ 
				'code' => 'DM', 
				'name' => 'Dominica', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.55122979066606' 
			],
			[ 
				'code' => 'DO', 
				'name' => 'Dominican Republic', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.45967860984716' 
			],
			[ 
				'code' => 'EC', 
				'name' => 'Ecuador', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.40378000225243' 
			],
			[ 
				'code' => 'TP', 
				'name' => 'Eswatini', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.042965859968045' 
			],
			[ 
				'code' => 'EG', 
				'name' => 'Egypt', 
				'hotel_factor' =>'65.382682614812', 
				'home_factor' =>'0.41117411274534' 
			],
			[ 
				'code' => 'SV', 
				'name' => 'El Salvador', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.34356031106696' 
			],
			[ 
				'code' => 'GQ', 
				'name' => 'Equatorial Guinea', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.53065042755125' 
			],
			[ 
				'code' => 'ER', 
				'name' => 'Eritrea', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.73933450906057' 
			],
			[ 
				'code' => 'EE', 
				'name' => 'Estonia', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.73336114974002' 
			],
			[ 
				'code' => 'ET', 
				'name' => 'Ethiopia', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.043590022691635' 
			],
			[ 
				'code' => 'FK', 
				'name' => 'Falkland Islands (Malvinas)', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.39856168124' 
			],
			[ 
				'code' => 'FO', 
				'name' => 'Faroe Islands', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.36161215910636' 
			],
			[ 
				'code' => 'FJ', 
				'name' => 'Fiji', 
				'hotel_factor' =>'48.993336037299', 
				'home_factor' =>'0.42833320844498' 
			],
			[ 
				'code' => 'FI', 
				'name' => 'Finland', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.16228633929528' 
			],
			[ 
				'code' => 'FR', 
				'name' => 'France', 
				'hotel_factor' =>'8.0126184545605', 
				'home_factor' =>'0.098687009945127' 
			],
			[ 
				'code' => 'GF', 
				'name' => 'French Guiana', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.33516351081502' 
			],
			[ 
				'code' => 'PF', 
				'name' => 'French Polynesia', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.44274404645671' 
			],
			[ 
				'code' => 'TF', 
				'name' => 'French Southern Territories', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.52194015744422' 
			],
			[ 
				'code' => 'GA', 
				'name' => 'Gabon', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.43945275771473' 
			],
			[ 
				'code' => 'GM', 
				'name' => 'Gambia', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.64271049257713' 
			],
			[ 
				'code' => 'GE', 
				'name' => 'Georgia', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.19460845386625' 
			],
			[ 
				'code' => 'DE', 
				'name' => 'Germany', 
				'hotel_factor' =>'22.5720267114', 
				'home_factor' =>'0.36573113096239' 
			],
			[ 
				'code' => 'GH', 
				'name' => 'Ghana', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.35978859361578' 
			],
			[ 
				'code' => 'GI', 
				'name' => 'Gibraltar', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.39805393622666' 
			],
			[ 
				'code' => 'GR', 
				'name' => 'Greece', 
				'hotel_factor' =>'56.627685720006', 
				'home_factor' =>'0.44871586213607' 
			],
			[ 
				'code' => 'GL', 
				'name' => 'Greenland', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.3665902015301' 
			],
			[ 
				'code' => 'GD', 
				'name' => 'Grenada', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.55691001669319' 
			],
			[ 
				'code' => 'GP', 
				'name' => 'Guadeloupe', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.45381288375012' 
			],
			[ 
				'code' => 'GU', 
				'name' => 'Guam', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.44685342096054' 
			],
			[ 
				'code' => 'GT', 
				'name' => 'Guatemala', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.40228239861624' 
			],
			[ 
				'code' => 'GT', 
				'name' => 'Guernsey', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.52194015744422' 
			],
			[ 
				'code' => 'GN', 
				'name' => 'Guinea', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.48433562529589' 
			],
			[ 
				'code' => 'GW', 
				'name' => 'Guinea-Bissau', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.65593151566122' 
			],
			[ 
				'code' => 'GY', 
				'name' => 'Guyana', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.60734306138774' 
			],
			[ 
				'code' => 'HT', 
				'name' => 'Haiti', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.70288923871772' 
			],
			[ 
				'code' => 'HM', 
				'name' => 'Heard Island and McDonald Islands', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.52194015744422' 
			],
			[ 
				'code' => 'HN', 
				'name' => 'Holy See', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.25158874271278' 
			],
			[ 
				'code' => 'HN', 
				'name' => 'Honduras', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.47286282363084' 
			],
			[ 
				'code' => 'HK', 
				'name' => 'Hong Kong, China', 
				'hotel_factor' =>'84.426438475335',
				'home_factor' => NULL  
			],
			[ 
				'code' => 'HU', 
				'name' => 'Hungary', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.24798129328726', 
			],
			[ 
				'code' => 'IS', 
				'name' => 'Iceland', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.042965869901361', 
			],
			[ 
				'code' => 'IN', 
				'name' => 'India', 
				'hotel_factor' =>'93.198799142637', 
				'home_factor' =>'0.67268181972485',  
			],
			[ 
				'code' => 'ID', 
				'name' => 'Indonesia', 
				'hotel_factor' =>'110.36761417536', 
				'home_factor' =>'0.63731060180549',  
			],
			[ 
				'code' => 'IR', 
				'name' => 'Iran (Islamic Republic of)', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.47030732404123', 
			],
			[ 
				'code' => 'IQ', 
				'name' => 'Iraq', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.93391015500616', 
			],
			[ 
				'code' => 'IE', 
				'name' => 'Ireland', 
				'hotel_factor' =>'31.775165187017', 
				'home_factor' =>'0.22559816807031',  
			],
			[ 
				'code' => 'IL', 
				'name' => 'Isle of Man', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.30307175771032'
			],
			[ 
				'code' => 'IL', 
				'name' => 'Israel', 
				'hotel_factor' =>'72.598080586953',
				'home_factor' => '0.30307175771032'
			],
			[ 
				'code' => 'IT', 
				'name' => 'Italy', 
				'hotel_factor' =>'26.199251568087', 
				'home_factor' =>'0.25158874271278',  
			],
			[ 
				'code' => 'CI', 
				'name' => 'Côte d’Ivoire', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.52194015744422'
			],
			[ 
				'code' => 'JM', 
				'name' => 'Jamaica', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.54261864422101' 
			],
			[ 
				'code' => 'JP', 
				'name' => 'Japan', 
				'hotel_factor' =>'81.861440127167', 
				'home_factor' =>'0.38112993644472',  
			],
			[ 
				'code' => 'JO', 
				'name' => 'Jersey',
				'hotel_factor' => NULL, 
				'home_factor' =>'0.52194015744422' 
			],
			[ 
				'code' => 'JO', 
				'name' => 'Jordan', 
				'hotel_factor' =>'80.477135131264', 
				'home_factor' =>'0.515787659395',  
			],
			[ 
				'code' => 'KZ', 
				'name' => 'Kazakhstan', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.65337341343796' 
			],
			[ 
				'code' => 'KE', 
				'name' => 'Kenya', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.31705608872117' 
			],
			[ 
				'code' => 'KR', 
				'name' => 'Korea', 
				'hotel_factor' =>'85.19047283182', 
				'home_factor' =>NULL,  
			],
			[ 
				'code' => 'KI', 
				'name' => 'Kiribati', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.60238873377057' 
			],
			[ 
				'code' => 'KW', 
				'name' => 'Kuwait', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.40655552970304' 
			],
			[ 
				'code' => 'KG', 
				'name' => 'Kyrgyzstan', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.15611526495919' 
			],
			[ 
				'code' => 'LA', 
				'name' => 'Lao People\'s Democratic Republic', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.36559161814481' 
			],
			[ 
				'code' => 'LV', 
				'name' => 'Latvia', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.17699648375643' 
			],
			[ 
				'code' => 'LB', 
				'name' => 'Lebanon', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.55214266711364' 
			],
			[ 
				'code' => 'LS', 
				'name' => 'Lesotho', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.042965859968045' 
			],
			[ 
				'code' => 'LR', 
				'name' => 'Liberia', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.40708518194064' 
			],
			[ 
				'code' => 'LY', 
				'name' => 'Libya', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.53781732254241' 
			],
			[ 
				'code' => 'LI', 
				'name' => 'Liechtenstein', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.097093086602375' 
			],
			[ 
				'code' => 'LT', 
				'name' => 'Lithuania', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.21499322169879' 
			],
			[ 
				'code' => 'LU', 
				'name' => 'Luxembourg', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.19077316489489' 
			],
			[ 
				'code' => 'MG', 
				'name' => 'Madagascar', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.37748296437983' 
			],
			[ 
				'code' => 'MC', 
				'name' => 'Macau, China', 
				'hotel_factor' =>'109.01410445195', 
				'home_factor' =>NULL,  
			],
			[ 
				'code' => 'MG', 
				'name' => 'Malawi', 
				'hotel_factor' =>NULL,
				'home_factor' => '0.042965859968045'
			],
			[ 
				'code' => 'MY', 
				'name' => 'Malaysia', 
				'hotel_factor' =>'95.935130175481', 
				'home_factor' =>'0.47041038402285'
			],
			[ 
				'code' => 'MV', 
				'name' => 'Maldives', 
				'hotel_factor' =>'218.68109608622', 
				'home_factor' =>'0.55285139253271'
			],
			[ 
				'code' => 'ML', 
				'name' => 'Mali', 
				'hotel_factor' =>NULL, 
				'home_factor' =>'0.54994937359019'
			],
			[ 
				'code' => 'MT', 
				'name' => 'Malta', 
				'hotel_factor' =>NULL, 
				'home_factor' =>'0.45617127465575'
			],
			[ 
				'code' => 'MH', 
				'name' => 'Marshall Islands', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.61039513085489'
			],
			[ 
				'code' => 'MQ', 
				'name' => 'Martinique', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.46835996899367'
			],
			[ 
				'code' => 'MR', 
				'name' => 'Mauritania', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.51222904905073'
			],
			[ 
				'code' => 'MU', 
				'name' => 'Mauritius', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.55224520912656'
			],
			[ 
				'code' => 'TY', 
				'name' => 'Mayotte', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.54504175258599'
			],
			[ 
				'code' => 'MX', 
				'name' => 'Mexico', 
				'hotel_factor' => '30.517575639178', 
				'home_factor' =>'0.31962067261904'
			],
			[ 
				'code' => 'FM', 
				'name' => 'Micronesia (Federated States of)', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.60997110461533'
			],
			[ 
				'code' => 'MC', 
				'name' => 'Monaco', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.042965859968045'
			],
			[ 
				'code' => 'MN', 
				'name' => 'Mongolia', 
				'hotel_factor' => NULL, 
				'home_factor' =>'1.0489569616966'
			],
			[ 
				'code' => 'MN', 
				'name' => 'Montenegro', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.54354549959399'
			],
			[ 
				'code' => 'MS', 
				'name' => 'Montserrat', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.54220225130533'
			],
			[ 
				'code' => 'MA', 
				'name' => 'Morocco', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.55057909980594'
			],
			[ 
				'code' => 'MZ', 
				'name' => 'Mozambique', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.12829770180321'
			],
			[ 
				'code' => 'MM', 
				'name' => 'Myanmar', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.36688304170288'
			],
			[ 
				'code' => 'NA', 
				'name' => 'Namibia', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.13352295647002'
			],
			[ 
				'code' => 'NR', 
				'name' => 'Nauru', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.56761420888426'
			],
			[ 
				'code' => 'NP', 
				'name' => 'Nepal', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.042965859968045'
			],
			[ 
				'code' => 'NL', 
				'name' => 'Netherlands', 
				'hotel_factor' => '23.778370136882', 
				'home_factor' =>'0.22128845924512'
			],
			[ 
				'code' => 'NC', 
				'name' => 'New Caledonia', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.41738837582162'
			],
			[ 
				'code' => 'NZ', 
				'name' => 'New Zealand', 
				'hotel_factor' => '11.56717216884', 
				'home_factor' =>'0.15987297380931'
			],
			[ 
				'code' => 'NI', 
				'name' => 'Nicaragua', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.4289226624989'
			],
			[ 
				'code' => 'NE', 
				'name' => 'Niger', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.74878051902221'
			],
			[ 
				'code' => 'NG', 
				'name' => 'Nigeria', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.39531206159723'
			],
			[ 
				'code' => 'NU', 
				'name' => 'Niue', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.35508443748957'
			],
			[ 
				'code' => 'NF', 
				'name' => 'Norfolk Island', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.52194015744422'
			],
			[ 
				'code' => 'NF', 
				'name' => 'North Macedonia', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.69079323816859'
			],
			[ 
				'code' => 'MP', 
				'name' => 'Northern Mariana Islands', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.48591369793033'
			],
			[ 
				'code' => 'NO', 
				'name' => 'Norway', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.061151111598052'
			],
			[ 
				'code' => 'OM', 
				'name' => 'Oman', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.381093524704'
			],
			[ 
				'code' => 'PK', 
				'name' => 'Pakistan', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.45348298066092'
			],
			[ 
				'code' => 'PW', 
				'name' => 'Palau', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.53036919913322'
			],
			[ 
				'code' => 'PA', 
				'name' => 'Panama', 
				'hotel_factor' => '31.723971121521', 
				'home_factor' =>'0.36063981814283'
			],
			[ 
				'code' => 'PG', 
				'name' => 'Papua New Guinea', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.46802356132563'
			],
			[ 
				'code' => 'PY', 
				'name' => 'Paraguay', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.042971617965758'
			],
			[ 
				'code' => 'PE', 
				'name' => 'Peru', 
				'hotel_factor' => '28.653892337826', 
				'home_factor' =>'0.30128063491656'
			],
			[ 
				'code' => 'PH', 
				'name' => 'Philippines', 
				'hotel_factor' => '66.539423095835', 
				'home_factor' =>'0.48887392070945'
			],
			[ 
				'code' => 'PN', 
				'name' => 'Pitcairn', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.52194015744422'
			],
			[ 
				'code' => 'PL', 
				'name' => 'Poland', 
				'hotel_factor' => '39.119207916083', 
				'home_factor' =>'0.56791010986604'
			],
			[ 
				'code' => 'PT', 
				'name' => 'Portugal', 
				'hotel_factor' => '36.473384752626', 
				'home_factor' =>'0.2627103894226'
			],
			[ 
				'code' => 'PR', 
				'name' => 'Puerto Rico', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.38983980966699'
			],
			[ 
				'code' => 'QA', 
				'name' => 'Qatar', 
				'hotel_factor' => '165.17598310802', 
				'home_factor' =>'0.27575832416256'
			],
			[ 
				'code' => 'SS', 
				'name' => 'Republic of Korea', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.29089868624881'
			],
			[ 
				'code' => 'SS', 
				'name' => 'Republic of Moldova', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.43631223093635'
			],
			[ 
				'code' => 'RO', 
				'name' => 'Romania', 
				'hotel_factor' => '34.161833982092', 
				'home_factor' =>'0.33220751309598'
			],
			[ 
				'code' => 'RU', 
				'name' => 'Russian Federation', 
				'hotel_factor' => '37.980628163173', 
				'home_factor' =>'0.35237493213459'
			],
			[ 
				'code' => 'RW', 
				'name' => 'Rwanda', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.46086984780243'
			],
			[ 
				'code' => 'RE', 
				'name' => 'Réunion', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.42996008871178'
			],
			[ 
				'code' => 'KN', 
				'name' => 'Saint Helena', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.30980307477631'
			],
			[ 
				'code' => 'BLM',
				'name' => 'Saint Barthélemy', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.52194015744422'
			],
			[ 
				'code' => 'KN', 
				'name' => 'Saint Kitts and Nevis', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.50199619234508'
			],
			[ 
				'code' => 'LC', 
				'name' => 'Saint Lucia', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.56124028428165'
			],
			[ 
				'code' => 'LC', 
				'name' => 'Saint Martin (French Part)', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.48681167280757'
			],
			[ 
				'code' => 'LC', 
				'name' => 'Saint Pierre and Miquelon', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.43234137158549'
			],
			[ 
				'code' => 'VC', 
				'name' => 'Saint Vincent and the Grenadines', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.52085110212607'
			],
			[ 
				'code' => 'WS', 
				'name' => 'Samoa', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.4586787150284'
			],
			[ 
				'code' => 'SM', 
				'name' => 'San Marino', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.042965859968045'
			],
			[ 
				'code' => 'ST', 
				'name' => 'Sao Tome and Principe', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.53017970925901'
			],
			[ 
				'code' => 'ST', 
				'name' => 'Sark', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.52194015744422'
			],
			[ 
				'code' => 'SA', 
				'name' => 'Saudi Arabia', 
				'hotel_factor' => '156.6433701162', 
				'home_factor' =>'0.47452624970681'
			],
			[ 
				'code' => 'SN', 
				'name' => 'Senegal', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.56768599201094'
			],
			[ 
				'code' => 'RS', 
				'name' => 'Serbia', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.69032799387054'
			],
			[ 
				'code' => 'SC', 
				'name' => 'Seychelles', 
				'hotel_factor' => NULL,
				'home_factor' => '0.51561380881781'
			],
			[ 
				'code' => 'SL', 
				'name' => 'Sierra Leone', 
				'hotel_factor' => NULL,
				'home_factor' => '0.45526398320508'
			],
			[ 
				'code' => 'SG', 
				'name' => 'Singapore',
				'hotel_factor' =>  '51.331988006269', 
				'home_factor' =>'0.24879955503585'],
			[ 
				'code' => 'SG', 
				'name' => 'Sint Maarten (Dutch part)', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.4690404886211'
			],
			[ 
				'code' => 'SK', 
				'name' => 'Slovak Republic', 
				'hotel_factor' => '21.340126307499',
				'home_factor' => NULL
			],
			[ 
				'code' => 'SI', 
				'name' => 'Slovenia', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.32868310166858'
			],
			[ 
				'code' => 'SB', 
				'name' => 'Solomon Islands', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.63067304426874'
			],
			[ 
				'code' => 'SO', 
				'name' => 'Somalia', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.65793217802499'
			],
			[ 
				'code' => 'ZA', 
				'name' => 'South Africa', 
				'hotel_factor' => '82.362166161135', 
				'home_factor' =>'0.83051803046234'
			],
			[ 
				'code' => 'GS', 
				'name' => 'South Georgia and the South Sandwich Islands',
				'hotel_factor' =>  NULL, 
				'home_factor' =>'0.52194015744422'],
			[ 
				'code' => 'GS', 
				'name' => 'South Sudan', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.74252889718098'
			],
			[ 
				'code' => 'ES', 
				'name' => 'Spain', 
				'hotel_factor' => '20.073118751679', 
				'home_factor' =>'0.23603421644528'
			],
			[ 
				'code' => 'LK', 
				'name' => 'Sri Lanka', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.46810625912219'
			],
			[ 
				'code' => 'SH', 
				'name' => 'State of Palestine', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.56936170908505'
			],
			[ 
				'code' => 'SD', 
				'name' => 'Sudan', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.35217919526546'
			],
			[ 
				'code' => 'SR', 
				'name' => 'Suriname', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.48500195073923'
			],
			[ 
				'code' => 'SJ', 
				'name' => 'Svalbard and Jan Mayen Islands', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.52194015744422'
			],
			[ 
				'code' => 'SE', 
				'name' => 'Sweden', 
				'hotel_factor' => NULL,
				'home_factor' => '0.064071662470733'
			],
			[ 
				'code' => 'CH', 
				'name' => 'Switzerland', 
				'hotel_factor' => '10.745317978367', 
				'home_factor' =>'0.055307841925273'
			],
			[ 
				'code' => 'SY', 
				'name' => 'Syrian Arab Republic', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.52501955741959'
			],
			[ 
				'code' => 'TJ', 
				'name' => 'Tajikistan', 
				'hotel_factor' => NULL,
				'home_factor' => '0.063174214953683'
			],
			[ 
				'code' => 'TH', 
				'name' => 'Thailand', 
				'hotel_factor' => '59.047166072401', 
				'home_factor' =>'0.38962460457155'
			],
			[ 
				'code' => 'TH', 
				'name' => 'Timor-Leste', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.63020742841545'
			],
			[ 
				'code' => 'TG', 
				'name' => 'Togo', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.34112972017776'
			],
			[ 
				'code' => 'TK', 
				'name' => 'Tokelau',
				'hotel_factor' =>  NULL, 
				'home_factor' =>'0.52194015744422'
			],
			[ 
				'code' => 'TO', 
				'name' => 'Tonga', 
				'hotel_factor' => NULL,
				'home_factor' => '0.58287643239646'
			],
			[ 
				'code' => 'TT', 
				'name' => 'Trinidad and Tobago', 
				'hotel_factor' => NULL,
				'home_factor' => '0.42435050193453'
			],
			[ 
				'code' => 'TN', 
				'name' => 'Tunisia', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.40406164852081'
			],
			[ 
				'code' => 'TN', 
				'name' => 'Taiwan, China', 
				'hotel_factor' => '117.81990810146', 
				'home_factor' =>NULL
			],
			[ 
				'code' => 'TR', 
				'name' => 'Turkey', 
				'hotel_factor' => '41.770225004116', 
				'home_factor' =>'0.31994850649083'
			],
			[ 
				'code' => 'TM', 
				'name' => 'Turkmenistan', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.69096961830879'
			],
			[ 
				'code' => 'TC', 
				'name' => 'Turks and Caicos Islands', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.4681890599041'
			],
			[ 
				'code' => 'TV', 
				'name' => 'Tuvalu', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.5281992261078'
			],
			[ 
				'code' => 'UG', 
				'name' => 'Uganda', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.13968866822655'
			],
			[ 
				'code' => 'UA', 
				'name' => 'Ukraine', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.52511235776095'
			],
			[ 
				'code' => 'AE', 
				'name' => 'United Arab Emirates', 
				'hotel_factor' => '145.46219520594', 
				'home_factor' =>'0.35330936528937'
			],
			[ 
				'code' => 'US', 
				'name' => 'United States', 
				'hotel_factor' => '23.037691394878',
				'home_factor' => NULL
			],
			[ 
				'code' => 'GB', 
				'name' => 'United Kingdom of Great Britain and Northern Ireland', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.25202231683116'
			],
			[ 
				'code' => 'UK', 
				'name' => 'United Kingdom', 
				'hotel_factor' => '18.411913834382',
				'home_factor' => NULL
			],
			[ 
				'code' => 'GB', 
				'name' => 'United Republic of Tanzania', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.47695258142714'
			],
			[ 
				'code' => 'UM', 
				'name' => 'United States of America', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.2846859511801'
			],
			[ 
				'code' => 'UM', 
				'name' => 'United States Minor Outlying Islands', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.52194015744422'
			],
			[ 
				'code' => 'UM', 
				'name' => 'United States Virgin Islands', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.3746374353935'
			],
			[ 
				'code' => 'UY', 
				'name' => 'Uruguay', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.15784367831134'
			],
			[ 
				'code' => 'UZ', 
				'name' => 'Uzbekistan', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.50611107689055'
			],
			[ 
				'code' => 'VU', 
				'name' => 'Vanuatu', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.37062886250339'
			],
			[ 
				'code' => 'VE', 
				'name' => 'Venezuela (Bolivarian Republic of)', 
				'hotel_factor' => NULL,
				'home_factor' => '0.34468894854759'
			],
			[ 
				'code' => 'VN', 
				'name' => 'Vietnam', 
				'hotel_factor' => '60.124075050204',
				'home_factor' => NULL
			],
			[ 
				'code' => 'WF', 
				'name' => 'Wallis and Futuna Islands', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.52194015744422'
			],
			[ 
				'code' => 'EH', 
				'name' => 'Western Sahara', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.52194015744422'
			],
			[ 
				'code' => 'YE', 
				'name' => 'Yemen', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.63642561380081'
			],
			[ 
				'code' => 'ZM', 
				'name' => 'Zambia', 
				'hotel_factor' => NULL, 
				'home_factor' =>'0.09872478326347'
			],
			[ 
				'code' => 'ZW', 
				'name' => 'Zimbabwe',
				'hotel_factor' => NULL, 
				'home_factor' =>'0.88254353619972'
			]
		];
		DB::table('countries')->insert($countries);
    }
}
