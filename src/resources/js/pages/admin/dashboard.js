import React from 'react';
import Frame from '@/layouts/admin/frame';
import { Grid, GridItem } from '@/components/grid';

export default function Dashboard(props) {
  return (
    <Frame page="Dashboard">
      <Grid>
        <GridItem className="bg-green-600" href={ route('submissions') }>Submissions</GridItem>
        <GridItem className="bg-orange-600" href={ route('teams') }>Teams</GridItem>
        <GridItem className="bg-purple-600" href={ route('challenges') }>Challenges</GridItem>
        <GridItem className="bg-cyan-600" href={ route('groups') }>Groups</GridItem>
      </Grid>
    </Frame>
  );
}
