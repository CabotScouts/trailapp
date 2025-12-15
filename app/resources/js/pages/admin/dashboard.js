import React from 'react';
import { Link } from '@inertiajs/react';
import Frame, { Container, Stripe } from '@/layouts/admin/frame';
import { Grid, GridItem } from '@/components/grid';

export default function Dashboard(props) {
  return (
    <Frame title="Dashboard" back="false">
      <Stripe>
        <div className="flex items-center">
          <div className="flex-grow pr-5 font-bold">{props.event.name}</div>
          <div className="flex-none">
            <Link href={route('toggle-event-running', props.event.id)}>
              {(props.event.running == true) &&
                <div className="mr-1 inline-flex items-center px-2 py-2 bg-green-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest">
                  Running
                </div>
              }
              {(props.event.running == false) &&
                <div className="mr-1 inline-flex items-center px-2 py-2 bg-red-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest">
                  Not Running
                </div>
              }
            </Link>
          </div>
        </div>
      </Stripe>

      <Container>
        <Grid>
          <GridItem className="bg-blue-600" href={route('broadcast')}>Broadcast</GridItem>
          <GridItem className="bg-teal-600" href={route('submissions')}>Submissions</GridItem>
          <GridItem className="bg-sky-600" href={route('leaderboard')}>Leaderboard</GridItem>
          <GridItem className="bg-emerald-600" href={route('teams')}>Teams</GridItem>
          <GridItem className="bg-green-600" href={route('questions')}>Questions</GridItem>
          <GridItem className="bg-orange-600" href={route('challenges')}>Challenges</GridItem>
          <GridItem className="bg-red-600" href={route('groups')}>Groups</GridItem>
          <GridItem className="bg-fuchsia-600" href={route('events')}>Events</GridItem>
          <GridItem className="bg-pink-600" href={route('users')}>Users</GridItem>
          <GridItem className="bg-zinc-600" href={route('logout')}>Logout</GridItem>
        </Grid>
      </Container>
    </Frame>
  );
}

// <GridItem className="bg-slate-600" href={ route('groups') }>Settings</GridItem>
