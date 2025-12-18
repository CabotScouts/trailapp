import React from 'react';
import { Head } from '@inertiajs/react';
import Global from '@/layouts/global';
import ListFrame from '@/layouts/list-frame';
import ListItem from '@/components/list-item';
import { __ } from '@/composables/translations';

export default function ChallengeList({ team, group, points, challenges }) {
  return (
    <Global>
      <Head title={__("Challenges")} />
      <ListFrame team={team} group={group} points={points}>
        {challenges.map(p => (<ListItem key={p.id} type="challenge" data={p} />))}
      </ListFrame>
    </Global>
  );
}
