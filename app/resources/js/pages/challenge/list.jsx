import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import ListFrame from '@/layouts/list-frame';
import ListItem from '@/components/list-item';

export default function ChallengeList({ team, group, points, challenges }) {
  return (
    <>
      <Head title="Challenges" />
      <ListFrame team={team} group={group} points={points}>
        {challenges.map(p => (<ListItem key={p.id} type="challenge" data={p} />))}
      </ListFrame>
    </>
  );
}
