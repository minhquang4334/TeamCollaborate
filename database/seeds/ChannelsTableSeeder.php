<?php

use Illuminate\Database\Seeder;

class ChannelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('channels')->insert([
            'type' => \App\Model\Channel::PUBLIC,
            'creator' => '0',
            'purpose' => 'This channel is for workspace-wide communication and announcements. All members are in this channel.',
            'description' => 'No description',
            'name' => 'General',
            'status' => \App\Model\Channel::ACTIVE,
            'channel_id' => \App\Model\Channel::GENERAL_CHANNEL_ID
        ]);
    }
}
