import React from 'react';
import Frame from '@/layouts/admin/frame';
import { Grid, GridItem } from '@/components/grid';

export default function Dashboard(props) {
  return (
    <Frame title="Dashboard" back="false">
      <Grid>
        <GridItem className="bg-rose-600" href={ route('broadcast') }>Broadcast</GridItem>
        <GridItem className="bg-sky-600" href={ route('leaderboard') }>Leaderboard</GridItem>
        <GridItem className="bg-teal-600" href={ route('submissions') }>Submissions</GridItem>
        <GridItem className="bg-emerald-600" href={ route('questions') }>Questions</GridItem>
        <GridItem className="bg-green-600" href={ route('challenges') }>Challenges</GridItem>
        <GridItem className="bg-orange-600" href={ route('teams') }>Teams</GridItem>
        <GridItem className="bg-red-600" href={ route('groups') }>Groups</GridItem>
        <GridItem className="bg-pink-600" href={ route('users') }>Users</GridItem> 
      </Grid>
    </Frame>
  );
}
 
// <GridItem className="bg-rose-600" href={ route('groups') }>Settings</GridItem>
