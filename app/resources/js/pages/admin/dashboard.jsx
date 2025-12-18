import React from 'react';
import { Link } from '@inertiajs/react';
import Frame, { Container, Stripe } from '@/layouts/admin/frame';
import { Grid, GridItem } from '@/components/grid';
import { __ } from '@/composables/translations';

export default function Dashboard(props) {
  return (
    <Frame title={__("Dashboard")} back="false">
      <Stripe>
        <div className="flex items-center">
          <div className="flex-grow pr-5 font-bold">{props.event.name}</div>
          <div className="flex-none">
            <Link href={route('toggle-event-running', props.event.id)}>
              {(props.event.running == true) &&
                <div className="mr-1 inline-flex items-center px-2 py-2 bg-green-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest">
                  {__("Running")}
                </div>
              }
              {(props.event.running == false) &&
                <div className="mr-1 inline-flex items-center px-2 py-2 bg-red-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest">
                  {__("Not Running")}
                </div>
              }
            </Link>
          </div>
        </div>
      </Stripe>

      <Container>
        <Grid>
          <GridItem className="bg-blue-600" href={route('broadcast')}>{__("Broadcast")}</GridItem>
          <GridItem className="bg-teal-600" href={route('submissions')}>{__("Submissions")}</GridItem>
          <GridItem className="bg-sky-600" href={route('leaderboard')}>{__("Leaderboard")}</GridItem>
          <GridItem className="bg-emerald-600" href={route('teams')}>{__("Teams")}</GridItem>
          <GridItem className="bg-green-600" href={route('questions')}>{__("Questions")}</GridItem>
          <GridItem className="bg-orange-600" href={route('challenges')}>{__("Challenges")}</GridItem>
          <GridItem className="bg-red-600" href={route('groups')}>{__("Groups")}</GridItem>
          <GridItem className="bg-fuchsia-600" href={route('events')}>{__("Events")}</GridItem>
          <GridItem className="bg-pink-600" href={route('users')}>{__("Users")}</GridItem>
          <GridItem className="bg-zinc-600" href={route('logout')}>{__("Logout")}</GridItem>
        </Grid>
      </Container>
    </Frame>
  );
}

// <GridItem className="bg-slate-600" href={ route('groups') }>Settings</GridItem>
